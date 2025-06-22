<?php
require_once(__DIR__.'/../../../../config.php');
require_once($CFG->libdir.'/pdflib.php');
require_once(__DIR__.'/invoice_generator.php');
use html_writer;
// Require login and capabilities
require_login();
$context = context_system::instance();
// require_capability('local/mist:viewinvoices', $context);

// Get invoice ID
$id = required_param('id', PARAM_INT);

// Fetch invoice data
$invoice = \local_mist\invoicing\invoice_generator::get_invoice($id);
if (!$invoice) {
    throw new moodle_exception('invoicenotfound', 'local_mist');
}


// Generate PDF content
$pdf = new \pdf();
$pdf->SetTitle(get_string('invoice', 'local_mist').' '.$invoice->reference);
$pdf->SetAuthor(fullname($USER));
$pdf->SetCreator('MIST Plugin');
$pdf->SetSubject(get_string('invoicefor', 'local_mist').' '.fullname($invoice->user));

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Prepare data for template

$data = [
    'invoice' => $invoice,
    'user' => \core_user::get_user($invoice->userid),
    'company' => [
        'name' => get_config('local_mist', 'invoice_companyname'),
        'address' => format_text(get_config('local_mist', 'invoice_companydetails'), FORMAT_HTML),
        'logo' => get_config('local_mist', 'invoice_logo')
    ],
    'dates' => [
        'created' => userdate($invoice->created, get_string('strftimedatefullshort', 'langconfig')),
        'due' => userdate($invoice->due, get_string('strftimedatefullshort', 'langconfig'))
    ],
    'currency' => get_config('local_mist', 'invoice_currency'),
    'status' => get_string('status_'.$invoice->status, 'local_mist')
];

// Get items if needed
if (!property_exists($invoice, 'items')) {
    $invoice->items = \local_mist\invoicing\invoice_generator::get_invoice_items($id);
}
$data['items'] = $invoice->items;
// var_dump($data); // Debugging line, remove in production
// die;
// Add totals calculation
$data['subtotal'] = 0;
$data['total_tax'] = 0;
$items_html = '';
foreach ($invoice->items as $item) {
    $data['subtotal'] += $item->amount * $item->quantity;
    $data['total_tax'] += $item->tax * $item->quantity;
    $items_html .= html_writer::tag('tr', 
        html_writer::tag('td', $item->description) .
        html_writer::tag('td', format_float($item->amount, 2)) .
        html_writer::tag('td', format_float($item->tax, 2)) .
        html_writer::tag('td', $item->quantity) .
        html_writer::tag('td', format_float($item->amount * $item->quantity + $item->tax * $item->quantity, 2))
    );
}
$data['items_html'] = $items_html;
$data['total'] = $data['subtotal'] + $data['tax'];

// Render HTML content
$html = $OUTPUT->render_from_template('local_mist/invoice_pdf', $data);

// Write HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Generate filename
$filename = clean_filename('invoice_'.$invoice->reference.'_'.date('Ymd').'.pdf');

// Output PDF
$pdf->Output($filename, 'D'); // 'D' for download, 'I' for inline
exit;