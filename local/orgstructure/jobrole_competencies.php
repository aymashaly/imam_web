<?php

require_once('../../config.php');
require_login();
require_capability('moodle/site:config', context_system::instance());

use local_orgstructure\form\jobrole_competency_form;

$PAGE->set_url(new moodle_url('/local/orgstructure/jobrole_competencies.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('managejobrolecompetencies', 'local_orgstructure'));
$PAGE->set_heading(get_string('managejobrolecompetencies', 'local_orgstructure'));
$PAGE->navbar->add(get_string('organizationalstructure', 'local_orgstructure'), new moodle_url('/local/orgstructure/manage.php'));
$PAGE->navbar->add(get_string('managejobrolecompetencies', 'local_orgstructure'));

$mform = new jobrole_competency_form();

if ($mform->is_cancelled()) {
    redirect($PAGE->url);
} elseif ($data = $mform->get_data()) {
    $record = new stdClass();
    $record->jobroleid = $data->jobroleid;
    $record->competencyid = $data->competencyid;
    $record->timecreated = time();
    $DB->insert_record('local_org_jobrole_competencies', $record);
    redirect($PAGE->url, get_string('recordadded', 'local_orgstructure'), 2);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('managejobrolecompetencies', 'local_orgstructure'));

$mform->display();

$joinsql = "SELECT j.name as jobrole, c.shortname as competency
            FROM {local_org_jobrole_competencies} jc
            JOIN {org_jobroles} j ON jc.jobroleid = j.id
            JOIN {competency} c ON jc.competencyid = c.id";

$records = $DB->get_records_sql($joinsql);

foreach ($records as $record) {
    echo html_writer::div("{$record->jobrole} -> {$record->competency}", 'alert alert-info');
}

echo $OUTPUT->footer();
