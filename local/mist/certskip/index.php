<?php

require('../../../config.php');
require_login();

$context = context_system::instance();
require_capability('local/mist:view', $context);

$PAGE->set_url(new moodle_url('/local/mist/view.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('viewrequests', 'local_mist'));
$PAGE->set_heading(get_string('viewrequests', 'local_mist'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('viewrequests', 'local_mist'));

global $DB, $USER;

$sql = "SELECT * FROM {local_mist_certskip} WHERE userid = :userid ORDER BY timecreated DESC";
$params = ['userid' => $USER->id];
$records = $DB->get_records_sql($sql, $params);

if ($records) {
    echo html_writer::start_tag('ul');
    foreach ($records as $record) {
        echo html_writer::tag('li', 
            "{$record->certificate_name} ({$record->issuing_body}) - " .
            get_string('status_' . $record->request_status, 'local_mist')
        );
        if($record->request_status == 'pending'){
            $approveurl = new moodle_url('/local/mist/certskip/action.php', ['action' => 'approve', 'id' => $record->id]);
            $refuseurl = new moodle_url('/local/mist/certskip/action.php', ['action' => 'refuse', 'id' => $record->id]);
    
            echo html_writer::link($approveurl, 'Approve', [
                'class' => 'btn btn-success',
                'onclick' => "return confirm('Approve this request?');"
            ]);
    
            echo html_writer::link($refuseurl, 'Refuse', [
                'class' => 'btn btn-danger',
                'onclick' => "return confirm('Refuse this request?');"
            ]);
        }
    }
    echo html_writer::end_tag('ul');
} else {
    echo get_string('norequestsfound', 'local_mist');
}

echo $OUTPUT->footer();
