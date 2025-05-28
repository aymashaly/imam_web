<?php
require_once(__DIR__ . '/../../../config.php');
require_login();
if (!is_siteadmin()) {
    throw new required_capability_exception(context_system::instance(), 'moodle/site:config', 'nopermissions', '');
}
$formid = required_param('formid', PARAM_INT);
$PAGE->set_url(new moodle_url('/local/mist/view_submissions.php', ['formid' => $formid]));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Form Submissions");
$PAGE->set_heading("Form Submissions");

global $DB, $OUTPUT;

// Get form
$form = $DB->get_record('formbuilder_forms', ['id' => $formid], '*', MUST_EXIST);

// Get all submissions
$submissions = $DB->get_records('formbuilder_submissions', ['formid' => $formid], 'timesubmitted ASC');

echo $OUTPUT->header();
echo html_writer::link(
    new moodle_url('/local/mist/form-builder/index.php'),
    '&larr; Back to Forms'
);
echo html_writer::tag('h2', format_string($form->name));
echo html_writer::tag('p', 'Showing all responses to this form.');

// Display each submission
if ($submissions) {
    foreach ($submissions as $submission) {
        $data = json_decode($submission->data, true);
        echo html_writer::start_div('submission', ['style' => 'border:1px solid #ccc; margin: 1em 0; padding: 1em;']);
        echo html_writer::tag('h4', "Submission #{$submission->id}");

        // Build a table
        $table = new html_table();
        $table->head = ['Field Name', 'Value'];
        foreach ($data as $key => $value) {
            if($key != "formdata")
            $table->data[] = [s($key), s($value)];
        }

        echo html_writer::table($table);
        echo html_writer::end_div();
    }
} else {
    echo html_writer::tag('p', 'No submissions yet.');
}

echo $OUTPUT->footer();
