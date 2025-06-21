<?php
require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once(__DIR__.'/classes/output/invoices_table.php');

defined('MOODLE_INTERNAL') || die();

// Check permissions
require_login();
$context = context_system::instance();
// require_capability('local/mist:viewinvoices', $context);

// Set up page
$url = new moodle_url('/local/mist/invoices.php');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('invoices', 'local_mist'));
$PAGE->set_heading(get_string('invoices', 'local_mist'));

// Add breadcrumbs
$PAGE->navbar->add(get_string('pluginname', 'local_mist'), new moodle_url('/local/mist/index.php'));
$PAGE->navbar->add(get_string('invoices', 'local_mist'));

// Get parameters for filtering
$download = optional_param('download', '', PARAM_ALPHA);
$perpage = optional_param('perpage', 20, PARAM_INT);

// Initialize table with filters
$filters = [
    'status' => optional_param('status', '', PARAM_ALPHA),
    'user' => optional_param('user', '', PARAM_TEXT),
    'fromdate' => optional_param('fromdate', 0, PARAM_INT),
    'todate' => optional_param('todate', 0, PARAM_INT)
];

$table = new \local_mist\output\invoices_table('mist_invoices', $filters);

// Handle download if requested
if ($download) {
    $table->is_downloading($download, 'invoices_export', 'Invoices Export');
    $table->out(0, false); // Show all records for download
    exit;
}

// Display page
echo $OUTPUT->header();

// Display filter form if needed
$filterform = new \local_mist\forms\invoice_filter_form();
$filterform->display();

// Display the table
$table->out($perpage, true);

// Add create button if user has permission
if (has_capability('local/mist:createinvoice', $context)) {
    echo html_writer::link(
        new moodle_url('/local/mist/invoice.php', ['id' => 0]),
        get_string('createnewinvoice', 'local_mist'),
        ['class' => 'btn btn-primary mt-3']
    );
}

echo $OUTPUT->footer();