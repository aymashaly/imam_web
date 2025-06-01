<?php
require_once(__DIR__ . '/../../../config.php');

require_login();
if (!is_siteadmin()) {
    throw new required_capability_exception(context_system::instance(), 'moodle/site:config', 'nopermissions', '');
}

$id = required_param('id', PARAM_INT);

$DB->delete_records('formbuilder_submissions', ['formid' => $id]);
$DB->delete_records('formbuilder_forms', ['id' => $id]);

redirect(new moodle_url('/local/mist/form-builder/index.php'), "Form deleted successfully.", 2);
