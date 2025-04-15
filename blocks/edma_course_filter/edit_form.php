<?php

class block_edma_course_filter_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;
        $edmaFontList = include($CFG->dirroot . '/theme/edma/inc/font_handler/edma_font_select.php');

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
        
        // Top Title
        $mform->addElement('text', 'config_top_title', get_string('config_top_title', 'theme_edma'));
        $mform->setDefault('config_top_title', 'Popular Courses');
        $mform->setType('config_top_title', PARAM_RAW);

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Expand Your Career Opportunity With Our Courses');
        $mform->setType('config_title', PARAM_RAW);

        // Total Student Title
        $mform->addElement('text', 'config_total_student_title', 'Total Students Title');
        $mform->setDefault('config_total_student_title', 'Total Student:');
        $mform->setType('config_total_student_title', PARAM_RAW);

        // Last Updated Title
        $mform->addElement('text', 'config_last_updated_title', 'Last Updated Title');
        $mform->setDefault('config_last_updated_title', 'Last Updated:');
        $mform->setType('config_last_updated_title', PARAM_RAW);

        // Enroll Now Title
        $mform->addElement('text', 'config_enroll_text', 'Enroll Now Button Text');
        $mform->setDefault('config_enroll_text', 'Enroll Now');
        $mform->setType('config_enroll_text', PARAM_RAW);

        $options = array(
            'multiple' => true,
            'noselectionstring' => get_string('select_from_dropdown_multiple', 'theme_edma'),
        );
        $mform->addElement('course', 'config_courses', get_string('courses'), $options);
    }
}
