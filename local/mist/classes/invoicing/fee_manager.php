<?php
namespace local_mist\invoicing;

defined('MOODLE_INTERNAL') || die();

class fee_manager {
    public static function get_fees($courseid = 0, $feetype = '') {
        global $DB;
        $params = [];
        $sql = "SELECT * FROM {local_mist_fees}";
        
        $conditions = [];
        if ($courseid) {
            $conditions[] = "courseid = :courseid";
            $params['courseid'] = $courseid;
        }
        if ($feetype) {
            $conditions[] = "feetype = :feetype";
            $params['feetype'] = $feetype;
        }
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        
        return $DB->get_records_sql($sql, $params);
    }

    public static function add_fee($data) {
        global $DB;
        $record = (object)[
            'courseid' => $data->courseid,
            'feetype' => $data->feetype,
            'amount' => $data->amount,
            'description' => $data->description,
            'taxable' => $data->taxable ? 1 : 0,
            'timecreated' => time(),
            'timemodified' => time()
        ];
        return $DB->insert_record('local_mist_fees', $record);
    }

    public static function delete_fee($feeid) {
        global $DB;
        return $DB->delete_records('local_mist_fees', ['id' => $feeid]);
    }

    public static function calculate_tax($amount) {
        $taxrate = get_config('local_mist', 'invoice_taxrate');
        return round($amount * ($taxrate / 100), 2);
    }
}