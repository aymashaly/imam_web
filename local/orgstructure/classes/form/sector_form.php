<?php
namespace local_orgstructure\form;

require_once("$CFG->libdir/formslib.php");

class sector_form extends \moodleform {
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'name', get_string('name', 'local_orgstructure'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $this->add_action_buttons();
    }
}
