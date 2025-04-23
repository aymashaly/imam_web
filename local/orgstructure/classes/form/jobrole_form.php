<?php
namespace local_orgstructure\form;

require_once("$CFG->libdir/formslib.php");

class jobrole_form extends \moodleform {
    public function definition() {
        global $DB;
        $mform = $this->_form;

        $departments = $DB->get_records_menu('org_departments', null, '', 'id, name');
        $mform->addElement('select', 'departmentid', 'Department', $departments);
        $mform->addRule('departmentid', null, 'required', null, 'client');

        $mform->addElement('text', 'name', get_string('name', 'local_orgstructure'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $this->add_action_buttons();
    }
}
