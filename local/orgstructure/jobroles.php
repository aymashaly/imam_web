<?php
require_once('../../config.php');
require_once(__DIR__ . '/lib.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

use local_orgstructure\form\jobrole_form;

$PAGE->set_url('/local/orgstructure/jobroles.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Manage Jobroles');
$PAGE->set_heading('Manage Jobroles');

$mform = new jobrole_form();

if ($mform->is_cancelled()) {
    redirect($PAGE->url);
} elseif ($data = $mform->get_data()) {
    $DB->insert_record('org_jobroles', $data);
    redirect($PAGE->url, "Sector added", 2);
}

echo $OUTPUT->header();
render_breadcrumb([
    ['label' => 'orgstructure', 'url' => new moodle_url('/local/orgstructure/manage.php')],
    ['label' => 'managejobroles']
]);

echo $OUTPUT->heading('Jobroles');
$PAGE->navbar->add('Organizational Structure', new moodle_url('/local/orgstructure/manage.php'));
$PAGE->navbar->add('Manage Job Roles');
$mform->display();

$jobroles = $DB->get_records('org_jobroles');
foreach ($jobroles as $Jobrole) {
    echo html_writer::div($Jobrole->name, 'alert alert-secondary');
}

echo $OUTPUT->footer();
