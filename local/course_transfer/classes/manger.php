<?php
namespace local_course_transfer;

defined('MOODLE_INTERNAL') || die();

class manager {
    public static function process_transfer($userid, $from, $to, $fee) {
        global $DB;

        $enrols = $DB->get_records('enrol', ['courseid' => $from]);
        foreach ($enrols as $enrol) {
            $DB->delete_records('user_enrolments', ['enrolid' => $enrol->id, 'userid' => $userid]);
        }

        $enrols = $DB->get_records('enrol', ['courseid' => $to]);
        foreach ($enrols as $enrol) {
            $userenrol = new \stdClass();
            $userenrol->enrolid = $enrol->id;
            $userenrol->userid = $userid;
            $userenrol->timestart = time();
            $userenrol->timecreated = time();
            $DB->insert_record('user_enrolments', $userenrol);
            break;
        }


        return true;
    }
}
