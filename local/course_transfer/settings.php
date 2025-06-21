<?php
defined('MOODLE_INTERNAL') || die();

$ADMIN->add('localplugins', new admin_category('local_course_transfer', get_string('pluginname', 'local_course_transfer')));

$ADMIN->add('root', new admin_externalpage(
    'managecourse_transfer',
    get_string('pluginname', 'local_course_transfer'),
    new moodle_url('/local/course_transfer/index.php')
));


