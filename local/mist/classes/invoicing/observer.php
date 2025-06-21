<?php
namespace local_mist\invoicing;

defined('MOODLE_INTERNAL') || die();

class observer {
    public static function user_enrolled(\core\event\user_enrolment_created $event) {
        global $DB;
        $enrolment = $event->get_record_snapshot('user_enrolments', $event->objectid);
        $courseid = $event->courseid;
        $userid = $event->relateduserid;
        
        $fees = fee_manager::get_fees($courseid, 'enrollment');
        if (empty($fees)) return;
        
        $items = [];
        foreach ($fees as $fee) {
            $items[] = (object)[
                'itemtype' => 'enrollment',
                'itemid' => $enrolment->id,
                'description' => $fee->description,
                'amount' => $fee->amount,
                'tax' => $fee->taxable ? fee_manager::calculate_tax($fee->amount) : 0,
                'quantity' => 1
            ];
        }
        
        invoice_generator::create_invoice($userid, $items);
    }

    public static function course_transfer(\local_mist\event\course_transfer_created $event) {
        $data = $event->get_data();
        $userid = $data['userid'];
        $courseid = $data['courseid'];
        
        $fees = fee_manager::get_fees($courseid, 'transfer');
        if (empty($fees)) return;
        
        $items = [];
        foreach ($fees as $fee) {
            $items[] = (object)[
                'itemtype' => 'transfer',
                'itemid' => $data['transferid'],
                'description' => get_string('coursetransferfee', 'local_mist', $data['coursename']),
                'amount' => $fee->amount,
                'tax' => $fee->taxable ? fee_manager::calculate_tax($fee->amount) : 0,
                'quantity' => 1
            ];
        }
        
        invoice_generator::create_invoice($userid, $items);
    }
    
    public static function extra_fee_triggered(\local_mist\event\extra_fee_created $event) {
        $data = $event->get_data();
        $items = [(object)[
            'itemtype' => 'extra',
            'itemid' => $data['feeid'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'tax' => fee_manager::calculate_tax($data['amount']),
            'quantity' => $data['quantity'] ?? 1
        ]];
        
        invoice_generator::create_invoice($data['userid'], $items);
    }
}