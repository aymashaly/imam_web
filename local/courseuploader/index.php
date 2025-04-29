<?php

require_once('../../config.php');
require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_url(new moodle_url('/local/courseuploader/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('pagetitle', 'local_courseuploader'));
$PAGE->set_heading(get_string('pageheading', 'local_courseuploader'));

echo $OUTPUT->header();

echo html_writer::start_tag('div', ['class' => 'courseupload-form']);
echo html_writer::start_tag('form', [
    'method' => 'post',
    'action' => new moodle_url('/local/courseuploader/upload.php'),
    'enctype' => 'multipart/form-data',
]);

echo html_writer::start_tag('fieldset');
echo html_writer::tag('legend', get_string('formlegend', 'local_courseuploader'));

echo html_writer::start_div('form-group');
echo html_writer::label(get_string('choosefile', 'local_courseuploader'), 'excelfile');
echo html_writer::empty_tag('input', [
    'type' => 'file',
    'name' => 'excelfile',
    'id' => 'excelfile',
    'accept' => '.xlsx',
    'required' => true
]);
echo html_writer::end_div();

echo html_writer::empty_tag('br');

echo html_writer::empty_tag('input', [
    'type' => 'submit',
    'value' => get_string('submitbtn', 'local_courseuploader'),
    'class' => 'btn btn-primary'
]);

echo html_writer::end_tag('fieldset');
echo html_writer::end_tag('form');
echo html_writer::end_tag('div');

echo $OUTPUT->footer();
