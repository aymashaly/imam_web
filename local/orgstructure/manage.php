<?php

require_once(__DIR__ . '/../../config.php');
require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_url(new moodle_url('/local/orgstructure/manage.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Manage Organizational Structure');
$PAGE->set_heading('Organizational Structure');

echo $OUTPUT->header();

echo $OUTPUT->heading('📊 Organizational Structure Management');

echo html_writer::start_div('mb-4');
echo html_writer::link(new moodle_url('sectors.php'), '➕ Add Sector', ['class' => 'btn btn-primary mr-2']);
echo html_writer::link(new moodle_url('departments.php'), '➕ Add Department', ['class' => 'btn btn-secondary mr-2']);
echo html_writer::link(new moodle_url('jobroles.php'), '➕ Add Job Role', ['class' => 'btn btn-success']);
echo html_writer::link(new moodle_url('jobrole_competencies.php'), get_string('managejobrolecompetencies', 'local_orgstructure'), ['class' => 'btn btn-warning ml-2']);
echo html_writer::end_div();

$sectors = $DB->get_records('org_sectors');

if (empty($sectors)) {
    echo html_writer::div('No sectors added yet.', 'alert alert-warning');
} else {
    foreach ($sectors as $sector) {
        echo html_writer::tag('h3', '📁 ' . $sector->name, ['class' => 'mt-4']);

        $departments = $DB->get_records('org_departments', ['sectorid' => $sector->id]);

        if (empty($departments)) {
            echo html_writer::div('No departments in this sector.', 'ml-4 text-muted');
            continue;
        }

        foreach ($departments as $dept) {
            echo html_writer::tag('h4', '🎯 ' . $dept->name, ['class' => 'ml-4 mt-2']);

            $roles = $DB->get_records('org_jobroles', ['departmentid' => $dept->id]);

            if (empty($roles)) {
                echo html_writer::div('No roles in this department.', 'ml-5 text-muted');
            } else {
                echo html_writer::start_tag('ul', ['class' => 'ml-5']);
                foreach ($roles as $role) {
                    echo html_writer::tag('li', '👤 ' . $role->name);
                }
                echo html_writer::end_tag('ul');
            }
        }
    }
}

echo $OUTPUT->footer();
