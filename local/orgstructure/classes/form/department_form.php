<?php
namespace local_orgstructure\form;

require_once("$CFG->libdir/formslib.php");

class department_form extends \moodleform {
    public function definition() {
        global $DB;
        $mform = $this->_form;

        $sectors = $DB->get_records_menu('org_sectors', null, '', 'id, name');
        $mform->addElement('select', 'sectorid', 'Sector', $sectors);
        $mform->addRule('sectorid', null, 'required', null, 'client');

        $mform->addElement('text', 'name', get_string('name', 'local_orgstructure'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $this->add_action_buttons();
    }
}
