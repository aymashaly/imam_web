<?php
require_once($CFG->dirroot . '/theme/edma/inc/course_handler/edma_course_handler.php');

class block_edma_about_area_two_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;
        $edmaFontList = include($CFG->dirroot . '/theme/edma/inc/font_handler/edma_font_select.php');

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        $style = 1;
        if(isset($this->block->config->style)){
            $style = $this->block->config->style;
        }
        $mform->addElement('select', 'config_style', get_string('config_style', 'theme_edma'), array(1 => 'Style 1', 2 => 'Style 2'));
        $mform->setDefault('config_style', 1);

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Become An Instructor Today And Start Teaching');
        $mform->setType('config_title', PARAM_RAW);

        // Content
        $mform->addElement('textarea', 'config_content', 'Bottom Title');
        $mform->setDefault('config_content', 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.');
        $mform->setType('config_content', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edma'));
        $mform->setDefault('config_button_text', 'Become An Instructor');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edma'));
        $mform->setDefault('config_button_link', $CFG->wwwroot . '/course');
        $mform->setType('config_button_link', PARAM_RAW);

        // Section Image
        $mform->addElement('text', 'config_img', 'Section Image URL');
        $mform->setType('config_img', PARAM_TEXT);

        // Section Shape Image
        $mform->addElement('text', 'config_shape_img', 'Shape Image URL');
        $mform->setType('config_shape_img', PARAM_TEXT);

        $items = 4;
        if(isset($this->block->config->items)){
            $items = $this->block->config->items;
        }

        $items_range = array(
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '9',
            10 => '10',
            11 => '11',
            12 => '12',
            13 => '13',
            14 => '14',
            15 => '15',
            16 => '16',
            17 => '17',
            18 => '18',
            19 => '19',
            20 => '20',
            21 => '21',
            22 => '22',
            23 => '23',
            24 => '24',
            25 => '25',
            26 => '26',
            27 => '27',
            28 => '28',
            29 => '29',
            30 => '30',
        );
        $items_max = 30;

        $mform->addElement('select', 'config_items', get_string('config_items', 'theme_edma'), $items_range);
        $mform->setDefault('config_items', 4);

        for($i = 1; $i <= $items; $i++) {
            $mform->addElement('header', 'config_edma_item' . $i , get_string('config_item', 'theme_edma') .' '. $i);

            // Image URL
            $mform->addElement('static', 'config_image_doc' . $i, '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>'); 

            $mform->addElement('text', 'config_img' . $i, 'Icon Image' . $i);
            $mform->setType('config_img' . $i, PARAM_TEXT);

             // Title
            $mform->addElement('text', 'config_features_title' . $i, get_string('config_title', 'theme_edma', $i));
            $mform->setDefault('config_features_title' . $i, 'Expert Instruction');
            $mform->setType('config_features_title' . $i, PARAM_TEXT);

        }
    }
}
