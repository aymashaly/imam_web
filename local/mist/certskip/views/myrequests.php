<?php

require('../../../../config.php');
require_login();

$context = context_system::instance();
require_capability('local/mist:view', $context);

$PAGE->set_url(new moodle_url('/local/mist/certskip/views/myrequests.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('myrequests', 'local_mist'));
$PAGE->set_heading(get_string('myrequests', 'local_mist'));

echo $OUTPUT->header();
echo html_writer::link(
    new moodle_url('/local/mist/index.php'),
    get_string('Back to Board','local_mist')
);
echo $OUTPUT->heading(get_string('myrequests', 'local_mist'));

global $DB, $USER;
$userid = $USER->id;
$sql = "SELECT * FROM {local_mist_certskip} WHERE userid = $userid ORDER BY timecreated DESC";
$records = $DB->get_records_sql($sql);

if ($records) {
    echo html_writer::start_tag('ul');
    foreach ($records as $record) {
        echo html_writer::tag('li', 
            "{$record->certificate_name} ({$record->issuing_body}) - " .
            get_string('status_' . $record->request_status, 'local_mist')
        ).html_writer::link(new moodle_url('/local/mist/certskip/views/view.php', ['id' => $record->id]), get_string('view','local_mist'), [
                'class' => 'btn btn-info',
        ]);
    }
    echo html_writer::end_tag('ul');
} else {
    echo get_string('norequestsfound', 'local_mist');
}

echo $OUTPUT->footer();
