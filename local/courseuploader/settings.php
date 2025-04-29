<?php

defined('MOODLE_INTERNAL') || die();

$ADMIN->add('localplugins', new admin_category('local_courseuploader', get_string('courseuploader', 'local_courseuploader')));

$ADMIN->add('root', new admin_externalpage(
    'manageorgstructure',
    get_string('courseuploader', 'local_courseuploader'),
    new moodle_url('/local/courseuploader/index.php')
));
