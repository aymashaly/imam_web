<?php
require_once('../../config.php');
require_once(__DIR__ . '/lib.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

use local_orgstructure\form\department_form;

$PAGE->set_url('/local/orgstructure/departments.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Manage Departments');
$PAGE->set_heading('Manage Departments');
$PAGE->navbar->add('Organizational Structure', new moodle_url('/local/orgstructure/manage.php'));
$PAGE->navbar->add('Manage Departments');
$mform = new department_form();

if ($mform->is_cancelled()) {
    redirect($PAGE->url);
} elseif ($data = $mform->get_data()) {
    $DB->insert_record('org_departments', $data);
    redirect($PAGE->url, "Sector added", 2);
}

echo $OUTPUT->header();
render_breadcrumb([
    ['label' => 'orgstructure', 'url' => new moodle_url('/local/orgstructure/manage.php')],
    ['label' => 'managedepartments']
]);
echo $OUTPUT->heading('Departments');

$mform->display();

$departments = $DB->get_records('org_departments');
foreach ($departments as $department) {
    echo html_writer::div($department->name, 'alert alert-secondary');
}

echo $OUTPUT->footer();
