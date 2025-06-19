<?php

require('../../../../config.php');
require_login();
require_once("$CFG->libdir/formslib.php");
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
    $filename = $mform->get_new_filename('certificate_file');
    $fileext = pathinfo($filename, PATHINFO_EXTENSION);
    $filename = time().".".$fileext;
    $fullpath = __DIR__."/../uploads/". $filename;
    $success = $mform->save_file('certificate_file', $fullpath, true);
    $fileurl = "/local/mist/certskip/uploads/$filename";
    // var_dump($success);
    // die();
    global $DB, $USER;
    
    $record = new stdClass();
    $record->userid = $USER->id;
    $record->courseid = $data->courseid;
    $record->certificate_name = $data->certificate_name;
    $record->issuing_body = $data->issuing_body;
    $record->date_issued = $data->date_issued;
    $record->request_status = 'pending';
    $record->timecreated = time();
    $record->timemodified = time();
    // Handle file upload if present.
    $record->file_path = $fileurl;
    $itemid = $DB->insert_record('local_mist_certskip', $record,true);
    $record->id = $itemid;
    redirect(new moodle_url('/local/mist/certskip/views/view.php?id='.$itemid), get_string('requestsubmitted', 'local_mist'));
}

echo $OUTPUT->header();
echo html_writer::link(
    new moodle_url('/local/mist/index.php'),
    get_string('Back to Board','local_mist')
);
echo $OUTPUT->heading(get_string('submitrequest', 'local_mist'));
$mform->display();
echo $OUTPUT->footer();
