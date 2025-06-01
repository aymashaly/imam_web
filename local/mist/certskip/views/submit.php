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
    // var_dump($mform->get_file_content('certificate_file'));
    // die();
    // var_dump($data);
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
    $record->file_path = '';
    $itemid = $DB->insert_record('local_mist_certskip', $record,true);
    $record->id = $itemid;
    if (!empty($data->certificate_file)) {
        $fs = get_file_storage();
        $context = context_system::instance(); // Or context for your plugin
        $component = 'local_mist';
        $filearea = 'attachment';

        file_save_draft_area_files(
            $data->certificate_file, // draft itemid from form
            $context->id,
            $component,
            $filearea,
            $itemid,
            ['subdirs' => 0, 'maxfiles' => 1]
        );

        // Optionally confirm file was saved
        $files = $fs->get_area_files($context->id, $component, $filearea, $itemid, '', false);
        if ($files) {
            $file = reset($files);
            $record->file_path = $file->get_filename(); // Just the filename
        }
        $DB->update_record('local_mist_certskip',$record);
    }

    

    
    redirect(new moodle_url('/local/mist/certskip/index.php'), get_string('requestsubmitted', 'local_mist'));
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('submitrequest', 'local_mist'));
$mform->display();
echo $OUTPUT->footer();
