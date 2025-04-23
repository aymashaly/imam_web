<?php
require_once('../../config.php');
require_once(__DIR__ . '/lib.php');
require_login();
require_capability('moodle/site:config', context_system::instance());

use local_orgstructure\form\sector_form;

$PAGE->set_url('/local/orgstructure/sectors.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Manage Sectors');
$PAGE->set_heading('Manage Sectors');


$mform = new sector_form();

if ($mform->is_cancelled()) {
    redirect($PAGE->url);
} elseif ($data = $mform->get_data()) {
    $DB->insert_record('org_sectors', $data);
    redirect($PAGE->url, "Sector added", 2);
}

echo $OUTPUT->header();
render_breadcrumb([
    ['label' => 'orgstructure', 'url' => new moodle_url('/local/orgstructure/manage.php')],
    ['label' => 'managesectors']
]);


$mform->display();

$sectors = $DB->get_records('org_sectors');
foreach ($sectors as $sector) {
    echo html_writer::div($sector->name, 'alert alert-secondary');
}

echo $OUTPUT->footer();
