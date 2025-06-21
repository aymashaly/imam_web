<?php
namespace local_mist\output;
require_once(__DIR__.'/../../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/tablelib.php');
use \moodle_url;
use \table_sql;
use \html_writer;
class invoices_table extends table_sql {
    protected $filters = [];
    
    public function __construct($uniqueid, $filters = []) {
        global $PAGE;
        parent::__construct($uniqueid);
        
        $this->filters = $filters;
        
        // Define columns and headers
        $this->define_columns([
            'reference', 
            'username', 
            'amount', 
            'tax', 
            'total', 
            'status', 
            'created', 
            'due',
            'actions'
        ]);
        
        $this->define_headers([
            get_string('invoiceref', 'local_mist'),
            get_string('user'),
            get_string('amount', 'local_mist'),
            get_string('tax', 'local_mist'),
            get_string('total', 'local_mist'),
            get_string('status'),
            get_string('datecreated', 'local_mist'),
            get_string('duedate', 'local_mist'),
            get_string('actions')
        ]);
        
        // Table configuration
        $this->sortable(true, 'timecreated', SORT_DESC);
        $this->no_sorting('actions');
        $this->pageable(true);
        $this->collapsible(false);
        $this->is_downloadable(true);
        
        $this->define_baseurl($PAGE->url);
        
        $this->setup();
    }
    
    protected function col_reference($row) {
        global $OUTPUT;
        $url = new moodle_url('/local/mist/invoice.php', ['id' => $row->id]);
        return html_writer::link($url, $row->reference);
    }

    protected function col_username($row) {
        global $OUTPUT;
        $user = (object)[
            'id' => $row->userid,
            'firstname' => $row->firstname,
            'lastname' => $row->lastname,
            'email' => $row->email
        ];
        return fullname($user);
    }

    protected function col_amount($row) {
        return format_float($row->amount, 2);
    }

    protected function col_tax($row) {
        return format_float($row->tax, 2);
    }

    protected function col_total($row) {
        return format_float($row->total, 2);
    }

    protected function col_status($row) {
        $statusclass = [
            'paid' => 'success',
            'overdue' => 'danger',
            'pending' => 'warning',
            'cancelled' => 'secondary'
        ][$row->status] ?? 'primary';
        
        return html_writer::span(
            get_string('status_' . $row->status, 'local_mist'),
            'badge badge-' . $statusclass
        );
    }

    protected function col_created($row) {
        return userdate($row->created, get_string('strftimedatetimeshort', 'langconfig'));
    }

    protected function col_due($row) {
        $date = userdate($row->due, get_string('strftimedateshort', 'langconfig'));
        if ($row->status === 'overdue') {
            return html_writer::span($date, 'text-danger font-weight-bold');
        }
        return $date;
    }

    protected function col_actions($row) {
        global $OUTPUT;
        
        $actions = [];
        
        $actions[] = [
            'url' => new moodle_url('/local/mist/classes/invoicing/invoice_pdf_generator.php', ['id' => $row->id]),
            'icon' => 'fa fa-file-pdf',
            'attributes' => ['title' => get_string('downloadpdf', 'local_mist')]
        ];
        // return '';
        return $OUTPUT->render_from_template('local_mist/invoice_actions', ['actions' => $actions]);
    }
    
    public function query_db($pagesize, $useinitialsbar=true) {
        global $DB;
        
        // Build the base SQL
        $fields = "i.id, i.reference, u.id AS userid, 
                  u.firstname, u.lastname, u.email,
                  i.amount, i.tax, i.total, i.status, 
                  i.created, i.due, i.timecreated";
                  
        $from = "{local_mist_invoices} i
                JOIN {user} u ON u.id = i.userid";
                
        $where = "1 = 1";
        $params = [];
        
        // Apply filters
        if (!empty($this->filters['status'])) {
            $where .= " AND i.status = :status";
            $params['status'] = $this->filters['status'];
        }
        
        if (!empty($this->filters['user'])) {
            $where .= " AND (" . $DB->sql_like('u.firstname', ':user1', false) . " 
                      OR " . $DB->sql_like('u.lastname', ':user2', false) . "
                      OR " . $DB->sql_like('u.email', ':user3', false) . ")";
            $params['user1'] = '%' . $DB->sql_like_escape($this->filters['user']) . '%';
            $params['user2'] = '%' . $DB->sql_like_escape($this->filters['user']) . '%';
            $params['user3'] = '%' . $DB->sql_like_escape($this->filters['user']) . '%';
        }
        
        if (!empty($this->filters['fromdate'])) {
            $where .= " AND i.created >= :fromdate";
            $params['fromdate'] = $this->filters['fromdate'];
        }
        
        if (!empty($this->filters['todate'])) {
            $where .= " AND i.created <= :todate";
            $params['todate'] = $this->filters['todate'];
        }
        
        // Set the SQL
        $this->set_sql($fields, $from, $where, $params);
        
        // Get count for pagination
        $this->set_count_sql("SELECT COUNT(i.id) FROM $from WHERE $where", $params);
        
        // Call parent to actually query the DB
        parent::query_db($pagesize, $useinitialsbar);
        
        // Debugging: Verify we got results
        if (empty($this->rawdata)) {
            debugging('No invoices found with current filters', DEBUG_DEVELOPER);
        }
    }
    
    public function print_nothing_to_display() {
        global $OUTPUT;
        
        echo $OUTPUT->notification(
            get_string('noinvoicesfound', 'local_mist'),
            'notifyinfo'
        );
        
        // Optionally show a button to create new invoice
        if (has_capability('local/mist:createinvoice', context_system::instance())) {
            echo $OUTPUT->single_button(
                new moodle_url('/local/mist/invoice.php', ['id' => 0]),
                get_string('createnewinvoice', 'local_mist'),
                'get'
            );
        }
    }
}