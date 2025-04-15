<?php

class block_edma_course_slider_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;
        $edmaFontList = include($CFG->dirroot . '/theme/edma/inc/font_handler/edma_font_select.php');

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Section Class
        $mform->addElement('text', 'config_class', get_string('config_class', 'theme_edma'));
        $mform->setDefault('config_class', 'feature-dcourses-area bg-color-f6fafb pt-100 pb-70');
        $mform->setType('config_class', PARAM_RAW);
        
        // Top Title
        $mform->addElement('text', 'config_top_title', get_string('config_top_title', 'theme_edma'));
        $mform->setDefault('config_top_title', 'Featured Courses');
        $mform->setType('config_top_title', PARAM_RAW);

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Find Yours From The Featured');
        $mform->setType('config_title', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edma'));
        $mform->setDefault('config_button_text', 'View All');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edma'));
        $mform->setDefault('config_button_link', $CFG->wwwroot . '/course');
        $mform->setType('config_button_link', PARAM_RAW);

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


        // Section Image header title according to language file.
        $mform->addElement('header', 'config_image_heading', get_string('config_image_heading', 'theme_edma'));

        $mform->addElement('static', 'config_image_doc', '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>'); 
            
        // Shape Images
        $mform->addElement('text', 'config_shape_img', 'Course Shape Image');
        $mform->setType('config_shape_img', PARAM_TEXT);
    }
}
