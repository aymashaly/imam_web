<?php
namespace local_mist\invoicing\task;

defined('MOODLE_INTERNAL') || die();

class generate_invoices extends \core\task\scheduled_task {
    public function get_name() {
        return get_string('generateinvoicestask', 'local_mist');
    }

    public function execute() {
        global $DB;
        
        if (!get_config('local_mist', 'invoice_enablecron')) return;
        
        $users = $this->get_users_with_pending_fees();
        
        foreach ($users as $user) {
            $this->process_user_invoices($user->id);
        }
    }
    
    private function get_users_with_pending_fees() {
        global $DB;
        
        // Customize this query based on your fee tracking system
        return $DB->get_records_sql("
            SELECT DISTINCT u.id
            FROM {user} u
            JOIN {local_mist_fee_tracking} ft ON ft.userid = u.id
            WHERE ft.status = 'pending'
              AND ft.timecreated < :cutoff
            ORDER BY u.id
        ", ['cutoff' => time() - 86400]); // Fees older than 1 day
    }
    
    private function process_user_invoices($userid) {
        global $DB;
        
        // Customize this to fetch pending fees for the user
        $pendingfees = $DB->get_records('local_mist_fee_tracking', [
            'userid' => $userid,
            'status' => 'pending'
        ]);
        
        if (empty($pendingfees)) return;
        
        $items = [];
        foreach ($pendingfees as $fee) {
            $items[] = (object)[
                'itemtype' => $fee->feetype,
                'itemid' => $fee->id,
                'description' => $fee->description,
                'amount' => $fee->amount,
                'tax' => $fee->tax,
                'quantity' => $fee->quantity
            ];
            
            // Mark fee as processed
            $fee->status = 'processed';
            $fee->timemodified = time();
            $DB->update_record('local_mist_fee_tracking', $fee);
        }
        
        $invoice = \local_mist\invoicing\invoice_generator::create_invoice($userid, $items);
        if ($invoice && get_config('local_mist', 'invoice_autosend')) {
            $this->send_invoice($invoice->id);
        }
    }
    
    private function send_invoice($invoiceid) {
        global $DB;
        
        $invoice = $DB->get_record('local_mist_invoices', ['id' => $invoiceid], '*', MUST_EXIST);
        $user = \core_user::get_user($invoice->userid);
        $pdfcontent = \local_mist\invoicing\invoice_generator::generate_pdf($invoiceid);
        
        $subject = get_string('invoicesubject', 'local_mist', $invoice->reference);
        $message = $this->render_email_message($invoice, $user);
        
        email_to_user(
            $user,
            \core_user::get_support_user(),
            $subject,
            strip_tags($message),
            $message,
            [
                [
                    'name' => "invoice_{$invoice->reference}.pdf",
                    'type' => 'application/pdf',
                    'content' => $pdfcontent
                ]
            ]
        );
    }
    
    private function render_email_message($invoice, $user) {
        global $OUTPUT;
        
        $data = [
            'user' => $user,
            'invoice' => $invoice,
            'company' => \local_mist\invoicing\invoice_generator::get_company_data(),
            'currency' => get_config('local_mist', 'invoice_currency'),
            'due_date' => userdate($invoice->due),
            'payment_instructions' => format_text(get_config('local_mist', 'invoice_paymentinstructions'), FORMAT_HTML)
        ];
        
        return $OUTPUT->render_from_template('local_mist/invoice_email', $data);
    }
}