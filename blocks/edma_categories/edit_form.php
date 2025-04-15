<?php
require_once($CFG->dirroot . '/theme/edma/inc/course_handler/edma_course_handler.php');

class block_edma_categories_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;
        $edmaFontList = include($CFG->dirroot . '/theme/edma/inc/font_handler/edma_font_select.php');
        $edmaCourseHandler = new edmaCourseHandler();
        $edmaCourseCategories = $edmaCourseHandler->edmaListCategories();

        $style = 1;
        if(isset($this->block->config->style)){
            $style = $this->block->config->style;
        }

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Top Title
        $mform->addElement('text', 'config_top_title', get_string('config_top_title', 'theme_edma'));
        $mform->setDefault('config_top_title', 'Top Categories');
        $mform->setType('config_top_title', PARAM_RAW);

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Browse Top Categories');
        $mform->setType('config_title', PARAM_RAW);

        // Bottom Title
        $mform->addElement('text', 'config_bottom_title', 'Bottom Title');
        $mform->setDefault('config_bottom_title', 'Browse All Different');
        $mform->setType('config_bottom_title', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edma'));
        $mform->setDefault('config_button_text', '124+ Categories ');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edma'));
        $mform->setDefault('config_button_link', $CFG->wwwroot . '/course');
        $mform->setType('config_button_link', PARAM_RAW);

        $items = 12;
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
        $mform->setDefault('config_items', 12);

        for($i = 1; $i <= $items; $i++) {
            $mform->addElement('header', 'config_edma_item' . $i , get_string('config_item', 'theme_edma') .' '. $i);

            $options = array(
                'multiple' => false,
            );
            $mform->addElement('autocomplete', 'config_category' . $i, get_string('category'), $edmaCourseCategories, $options);

            $select = $mform->addElement('select', 'config_icon' . $i, get_string('config_icon_class', 'theme_edma'), $edmaFontList, array('class'=>'edma_icon_class'));
            $select->setSelected('flaticon-web-programming');
        }
    }
}
