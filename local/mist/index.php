<?php

require_once('../../config.php');
require_login();

$PAGE->set_url(new moodle_url('/local/mist/certskip/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('dashboard', 'local_mist'));

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('dashboard', 'local_mist'));

echo html_writer::start_tag('ul');
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/statics/index.php'), get_string('statics', 'local_mist')));
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/certskip/index.php'), get_string('certskip', 'local_mist')));
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/certskip/views/submit.php'), get_string('apply_request', 'local_mist')));
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/form-builder/index.php'), get_string('form_builder', 'local_mist')));
echo html_writer::end_tag('ul');

echo $OUTPUT->footer();
