<?php
require('../../config.php');
require_login();

$coursefrom = required_param('course_from', PARAM_INT);
$courseto = required_param('course_to', PARAM_INT);
$fee = required_param('fee', PARAM_FLOAT);

require_once($CFG->dirroot.'/local/course_transfer/classes/manager.php');

$success = \local_course_transfer\manager::process_transfer($USER->id, $coursefrom, $courseto, $fee);

redirect(new moodle_url('/local/course_transfer/index.php'), get_string('transfer_success', 'local_course_transfer'), 3);
