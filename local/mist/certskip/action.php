<?php
require('../../../config.php');
require_login();

use local_mist\certskip\manager;

$action = required_param('action', PARAM_ALPHA);
$requestid = required_param('id', PARAM_INT);

// Optional: permission check (adjust based on your roles)
if (!is_siteadmin()) {
    throw new \moodle_exception('nopermissions', 'error', '', 'manage cert skip requests');
}

// Execute the requested action
switch ($action) {
    case 'approve':
        manager::approve_request($requestid);
        $msg = get_string('requestapproved', 'local_mist');
        break;

    case 'refuse':
        manager::refuse_request($requestid);
        $msg = get_string('requestrefused', 'local_mist');
        break;

    default:
        throw new \moodle_exception('invalidaction', 'local_mist');
}

redirect(new moodle_url('/local/mist/index.php'), $msg);
