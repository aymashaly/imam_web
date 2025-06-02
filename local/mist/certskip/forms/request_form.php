<?php

namespace local_mist\form;

require_once("$CFG->libdir/formslib.php");

class request_form extends \moodleform {
    public function get_enctype() {
        return 'multipart/form-data';
    }

    public function definition() {
        $mform = $this->_form;
        $attr = $mform->getAttributes();
        $attr['enctype'] = "multipart/form-data";
        $mform->setAttributes($attr);
        $mform->addElement('text', 'certificate_name', get_string('certificate_name', 'local_mist'));
        $mform->setType('certificate_name', PARAM_TEXT);
        $mform->addRule('certificate_name', null, 'required');

        $mform->addElement('text', 'issuing_body', get_string('issuing_body', 'local_mist'));
        $mform->setType('issuing_body', PARAM_TEXT);
        $mform->addRule('issuing_body', null, 'required');

        $mform->addElement('date_selector', 'date_issued', get_string('date_issued', 'local_mist'));
        $mform->addRule('date_issued', null, 'required');

        $mform->addElement('select', 'courseid', 'Course to skip', self::get_courses_list());
        $mform->addRule('courseid', null, 'required');

        $mform->addElement('filepicker', 'certificate_file', 'Upload Certificate', null, ['maxbytes' => 10485760, 'accepted_types' => '*']);
        // $mform->setType('certificate_file', PARAM_INT);

        $this->add_action_buttons();
    }

    private static function get_courses_list() {
        global $DB;
        $courses = $DB->get_records_menu('course', null, 'fullname ASC', 'id, fullname');
        return $courses;
    }
}
