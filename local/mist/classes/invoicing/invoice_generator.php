<?php
namespace local_mist\invoicing;

defined('MOODLE_INTERNAL') || die();

class invoice_generator {
    public static function create_invoice($userid, $items) {
        global $DB;
        
        $invoice = (object)[
            'userid' => $userid,
            'amount' => 0,
            'tax' => 0,
            'total' => 0,
            'status' => 'pending',
            'reference' => self::generate_reference(),
            'created' => time(),
            'due' => time() + (get_config('local_mist', 'invoice_duedays') * 86400),
            'timecreated' => time()
        ];
        
        $transaction = $DB->start_delegated_transaction();
        try {
            $invoice->id = $DB->insert_record('local_mist_invoices', $invoice);
            
            foreach ($items as $item) {
                $item->invoiceid = $invoice->id;
                $item->timecreated = time();
                $DB->insert_record('local_mist_invoice_items', $item);
                
                $invoice->amount += $item->amount * $item->quantity;
                $invoice->tax += $item->tax * $item->quantity;
            }
            
            $invoice->total = $invoice->amount + $invoice->tax;
            $DB->update_record('local_mist_invoices', $invoice);
            
            $transaction->allow_commit();
            return $invoice;
        } catch (\Exception $e) {
            $transaction->rollback($e);
            return false;
        }
    }

    public static function generate_pdf($invoiceid) {
        global $DB, $OUTPUT;
        
        $invoice = $DB->get_record('local_mist_invoices', ['id' => $invoiceid], '*', MUST_EXIST);
        $items = $DB->get_records('local_mist_invoice_items', ['invoiceid' => $invoiceid]);
        $user = \core_user::get_user($invoice->userid);
        
        $data = [
            'invoice' => $invoice,
            'user' => $user,
            'items' => $items,
            'company' => self::get_company_data(),
            'currency' => get_config('local_mist', 'invoice_currency'),
            'created_date' => userdate($invoice->created),
            'due_date' => userdate($invoice->due)
        ];
        
        $pdf = new \pdf();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->WriteHTML($OUTPUT->render_from_template('local_mist/invoice_pdf', $data));
        return $pdf->Output('', 'S');
    }
    
    private static function generate_reference() {
        $timestamp = time();
        $random = random_string(6);
        return "INV-{$timestamp}-{$random}";
    }
    
    private static function get_company_data() {
        return [
            'name' => get_config('local_mist', 'invoice_companyname'),
            'details' => format_text(get_config('local_mist', 'invoice_companydetails'), FORMAT_HTML),
            'logo' => get_config('local_mist', 'invoice_logo')
        ];
    }
    public static function get_invoice($invoice_id) {
        global $DB;

        if (!$invoice = $DB->get_record('local_mist_invoices', ['id' => $invoice_id], '*', MUST_EXIST)) {
            throw new \moodle_exception('invalidinvoice', 'local_mist');
        }

        return $invoice;
    }
    public static function get_invoice_items($invoice_id) {
        global $DB;

        if (!$invoice = $DB->get_record('local_mist_invoices', ['id' => $invoice_id], '*', MUST_EXIST)) {
            throw new \moodle_exception('invalidinvoice', 'local_mist');
        }

        return $DB->get_records('local_mist_invoice_items', ['invoiceid' => $invoice_id]);
    }
    public static function download_pdf($invoice_id){
        global $DB, $USER, $OUTPUT;

        if (!$invoice = $DB->get_record('local_mist_invoices', ['id' => $invoice_id], '*', MUST_EXIST)) {
            throw new \moodle_exception('invalidinvoice', 'local_mist');
        }

        if ($invoice->userid != $USER->id && !has_capability('local/mist:manageinvoices', context_system::instance())) {
            throw new \moodle_exception('nopermission', 'local_mist');
        }

        $pdfcontent = self::generate_pdf($invoice_id);
        $filename = clean_filename("invoice_{$invoice->reference}.pdf");

        send_file($pdfcontent, $filename, 0, 0, true, true);
    }
}