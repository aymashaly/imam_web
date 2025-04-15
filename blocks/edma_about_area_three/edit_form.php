<?php
require_once($CFG->dirroot . '/theme/edma/inc/course_handler/edma_course_handler.php');

class block_edma_about_area_three_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;
        $edmaFontList = include($CFG->dirroot . '/theme/edma/inc/font_handler/edma_font_select.php');

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Be A Member Of Edma Business & Start Earning Limitless Today');
        $mform->setType('config_title', PARAM_RAW);

        // Content
        $mform->addElement('textarea', 'config_content', 'Bottom Title');
        $mform->setDefault('config_content', 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.');
        $mform->setType('config_content', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edma'));
        $mform->setDefault('config_button_text', 'Get Edmo Business');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edma'));
        $mform->setDefault('config_button_link', $CFG->wwwroot . '/course');
        $mform->setType('config_button_link', PARAM_RAW);

        // Section Image
        $mform->addElement('text', 'config_img', 'Section Image URL');
        $mform->setType('config_img', PARAM_TEXT);

        // Image URL
        $mform->addElement('static', 'config_image_doc', '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>'); 
    }
}
