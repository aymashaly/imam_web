<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_course_transfer', get_string('pluginname', 'local_course_transfer'));

    $settings->add(new admin_setting_configtext(
        'local_course_transfer/transfer_fee',
        'Default Transfer Fee',
        'Fee amount to be paid for course transfer.',
        '10.00',
        PARAM_FLOAT
    ));

    $ADMIN->add('localplugins', $settings);
}
$ADMIN->add('localplugins', new admin_category('local_course_transfer', get_string('pluginname', 'local_course_transfer')));

$ADMIN->add('root', new admin_externalpage(
    'managecourse_transfer',
    get_string('pluginname', 'local_course_transfer'),
    new moodle_url('/local/course_transfer/index.php')
));


