<?php
namespace local_mist\certskip;
require_once($GLOBALS['CFG']->libdir . '/completionlib.php');
defined('MOODLE_INTERNAL') || die();

class manager {
    public static function approve_request($requestid) {
        global $DB;

        $request = $DB->get_record('local_mist_certskip', ['id' => $requestid]);
        $completion = new \completion_info(get_course($request->courseid));
        $coursemodules = get_coursemodules_in_course('assign', $request->courseid);
        foreach ($coursemodules as $cm) {
            $completion->update_state($cm, COMPLETION_COMPLETE, $request->userid);
        }

        
        $request->request_status = 'approved';
        $request->timemodified = time();
        $DB->update_record('local_mist_certskip', $request);
    }
    public static function refuse_request($requestid) {
        global $DB;
    
        $request = $DB->get_record('local_mist_certskip', ['id' => $requestid]);
        if (!$request) {
            throw new \moodle_exception('invalidrequestid', 'local_mist');
        }
    
        $request->request_status = 'refused';
        $request->timemodified = time();
        $DB->update_record('local_mist_certskip', $request);
    }
}
