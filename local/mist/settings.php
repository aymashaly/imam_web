<?php

defined('MOODLE_INTERNAL') || die();

$ADMIN->add('localplugins', new admin_category('local_mist', get_string('pluginname', 'local_mist')));

$ADMIN->add('root', new admin_externalpage(
    'managemist',
    get_string('pluginname', 'local_mist'),
    new moodle_url('/local/mist/index.php')
));
