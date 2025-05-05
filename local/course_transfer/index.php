<?php
require('../../config.php');
require_login();

$PAGE->set_url('/local/course_transfer/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('requesttransfer', 'local_course_transfer'));

echo $OUTPUT->header();
$fee = get_config('local_course_transfer', 'transfer_fee');
$userid = $USER->id;

$courses = enrol_get_users_courses($userid);
$targetcourses = $DB->get_records_sql("SELECT id, fullname FROM {course} WHERE id NOT IN (SELECT c.id FROM {course} c JOIN {user_enrolments} ue ON ue.enrolid IN (SELECT id FROM {enrol} WHERE courseid = c.id) WHERE ue.userid = ?)", [$userid]);

if (!$courses || !$targetcourses) {
    echo $OUTPUT->notification(get_string('no_courses_available', 'local_course_transfer'), 'notifyproblem');
    echo $OUTPUT->footer();
    exit;
}

echo html_writer::start_tag('form', ['method' => 'post', 'action' => 'process.php']);
echo html_writer::label(get_string('currentcourse', 'local_course_transfer'), 'course_from');
echo html_writer::select($courses, 'course_from');
echo html_writer::empty_tag('br');
echo html_writer::label(get_string('targetcourse', 'local_course_transfer'), 'course_to');
echo html_writer::select($targetcourses, 'course_to');
echo html_writer::empty_tag('br');
echo html_writer::label(get_string('transferfee', 'local_course_transfer'), 'fee');
echo html_writer::empty_tag('input', ['type' => 'number', 'name' => 'fee', 'value' => $fee, 'readonly' => 'readonly']);
echo html_writer::empty_tag('br');
echo html_writer::empty_tag('input', ['type' => 'submit', 'value' => get_string('submitrequest', 'local_course_transfer')]);
echo html_writer::end_tag('form');

echo $OUTPUT->footer();
