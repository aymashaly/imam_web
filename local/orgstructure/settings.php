<?php

defined('MOODLE_INTERNAL') || die();

$ADMIN->add('localplugins', new admin_category('local_orgstructure', get_string('orgstructure', 'local_orgstructure')));

$ADMIN->add('root', new admin_externalpage(
    'manageorgstructure',
    get_string('orgstructure', 'local_orgstructure'),
    new moodle_url('/local/orgstructure/manage.php')
));
