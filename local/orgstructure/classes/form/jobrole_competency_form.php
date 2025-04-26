<?php

namespace local_orgstructure\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class jobrole_competency_form extends \moodleform {

    public function definition() {
        global $DB;

        $mform = $this->_form;

        $jobroles = $DB->get_records_menu('local_org_jobroles', null, '', 'id, name');
        $competencies = $DB->get_records_menu('competency', null, '', 'id, shortname');

        $mform->addElement('select', 'jobroleid', get_string('jobrole', 'local_orgstructure'), $jobroles);
        $mform->addRule('jobroleid', null, 'required', null, 'client');

        $mform->addElement('select', 'competencyid', get_string('competency', 'local_orgstructure'), $competencies);
        $mform->addRule('competencyid', null, 'required', null, 'client');

        $this->add_action_buttons();
    }
}
