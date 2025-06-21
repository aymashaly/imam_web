<?php

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');

require_login();

$PAGE->set_url(new moodle_url('/local/mist/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('dashboard', 'local_mist'));
$PAGE->set_heading(get_string('dashboard', 'local_mist'));
$PAGE->set_pagelayout('admin');
echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('dashboard', 'local_mist'));

echo html_writer::start_tag('ul');
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/statics/index.php'), get_string('statics', 'local_mist')));
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/certskip/index.php'), get_string('certskip', 'local_mist')));
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/certskip/views/myrequests.php'), get_string('my_certskip_requests', 'local_mist')));
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/certskip/views/submit.php'), get_string('apply_request', 'local_mist')));
echo html_writer::tag('li', html_writer::link(new moodle_url('/local/mist/form-builder/index.php'), get_string('form_builder', 'local_mist')));
echo html_writer::tag('li', html_writer::link(
    new moodle_url('/local/orgstructure/manage.php'),
    get_string('orgstructure', 'local_orgstructure')
));
echo html_writer::tag('li', html_writer::link(
    new moodle_url('/local/mist/invoices.php'),
    get_string('invoices', 'local_mist')
));
echo html_writer::end_tag('ul');

echo $OUTPUT->footer();
