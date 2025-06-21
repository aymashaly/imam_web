<?php
defined('MOODLE_INTERNAL') || die();

// Create the main settings category - MUST be outside the $hassiteconfig block
$ADMIN->add('localplugins', new admin_category('local_mist', get_string('pluginname', 'local_mist')));

if ($hassiteconfig) {
    // Create and add the settings page
    $settings = new admin_settingpage('local_mist_settings', 
        get_string('settings', 'local_mist'),
        'moodle/site:config'
    );
    
    // Add settings page to the category
    $ADMIN->add('local_mist', $settings);
    
    // ============== Company Information ==============
    $settings->add(new admin_setting_heading(
        'local_mist/company_header',
        get_string('companyinfo', 'local_mist'),
        ''
    ));
    
    $settings->add(new admin_setting_configtext(
        'local_mist/invoice_companyname',
        get_string('invoice_companyname', 'local_mist'),
        get_string('invoice_companyname_desc', 'local_mist'),
        'Moodle Learning Inc.',
        PARAM_TEXT
    ));
    
    $settings->add(new admin_setting_configtextarea(
        'local_mist/invoice_companydetails',
        get_string('invoice_companydetails', 'local_mist'),
        get_string('invoice_companydetails_desc', 'local_mist'),
        "123 Education Street\nLearning City, LC 12345",
        PARAM_TEXT
    ));
    
    // ============== Invoice Settings ==============
    $settings->add(new admin_setting_heading(
        'local_mist/invoice_header',
        get_string('invoicesettings', 'local_mist'),
        ''
    ));
    
    $settings->add(new admin_setting_configtext(
        'local_mist/invoice_currency',
        get_string('invoice_currency', 'local_mist'),
        get_string('invoice_currency_desc', 'local_mist'),
        'USD',
        PARAM_TEXT,
        3
    ));
    
    $settings->add(new admin_setting_configtext(
        'local_mist/invoice_taxrate',
        get_string('invoice_taxrate', 'local_mist'),
        get_string('invoice_taxrate_desc', 'local_mist'),
        '0',
        PARAM_FLOAT
    ));
    
    $settings->add(new admin_setting_configtext(
        'local_mist/invoice_duedays',
        get_string('invoice_duedays', 'local_mist'),
        get_string('invoice_duedays_desc', 'local_mist'),
        '30',
        PARAM_INT
    ));
    
    // ============== Automation Settings ==============
    $settings->add(new admin_setting_heading(
        'local_mist/automation_header',
        get_string('automationsettings', 'local_mist'),
        ''
    ));
    
    $settings->add(new admin_setting_configcheckbox(
        'local_mist/invoice_enablecron',
        get_string('invoice_enablecron', 'local_mist'),
        get_string('invoice_enablecron_desc', 'local_mist'),
        1
    ));
    
    $settings->add(new admin_setting_configcheckbox(
        'local_mist/invoice_autosend',
        get_string('invoice_autosend', 'local_mist'),
        get_string('invoice_autosend_desc', 'local_mist'),
        1
    ));
    
    // ============== Payment Settings ==============
    $settings->add(new admin_setting_heading(
        'local_mist/payment_header',
        get_string('paymentsettings', 'local_mist'),
        ''
    ));
    
    $settings->add(new admin_setting_configtextarea(
        'local_mist/invoice_paymentinstructions',
        get_string('invoice_paymentinstructions', 'local_mist'),
        get_string('invoice_paymentinstructions_desc', 'local_mist'),
        get_string('defaultpaymentinstructions', 'local_mist'),
        PARAM_RAW
    ));
}

// Add external pages - MUST be outside the $hassiteconfig block
$ADMIN->add('root', new admin_externalpage(
    'managemist',
    get_string('managemist', 'local_mist'),
    new moodle_url('/local/mist/index.php'),
    'moodle/site:config'
));

// $ADMIN->add('local_mist', new admin_externalpage(
//     'local_mist_feemanagement',
//     get_string('feemanagement', 'local_mist'),
//     new moodle_url('/local/mist/fees.php'),
//     'moodle/site:config'
// ));