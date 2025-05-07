<?php

require('../../../../config.php');
require_login();

require_once($CFG->dirroot . '/local/mist/certskip/forms/request_form.php');

$context = context_system::instance();
require_capability('local/mist:view', $context);

$PAGE->set_url(new moodle_url('/local/mist/certskip/views/submit.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('submitrequest', 'local_mist'));
$PAGE->set_heading(get_string('submitrequest', 'local_mist'));

$mform = new \local_mist\form\request_form();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/mist/index.php'));
} else if ($data = $mform->get_data()) {
    global $DB, $USER;

    // تعامل مع الخدمة الأساسية في باكج mist هنا
    $record = new stdClass();
    $record->userid = $USER->id;
    $record->courseid = $data->courseid;
    $record->certificate_name = $data->certificate_name;
    $record->issuing_body = $data->issuing_body;
    $record->date_issued = $data->date_issued;
    $record->file_path = ''; // أو مسار الملف لو رفعته
    $record->request_status = 'pending';
    $record->timecreated = time();
    $record->timemodified = time();

    $DB->insert_record('local_mist_certskip', $record);
    redirect(new moodle_url('/local/mist/certskip/index.php'), get_string('requestsubmitted', 'local_mist'));
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('submitrequest', 'local_mist'));
$mform->display();
echo $OUTPUT->footer();
