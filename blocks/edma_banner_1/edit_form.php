<?php

class block_edma_banner_1_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;
        $edmaFontList = include($CFG->dirroot . '/theme/edma/inc/font_handler/edma_font_select.php');

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Improve Your Online Learning Experience Better Instantly');
        $mform->setType('config_title', PARAM_RAW);

        // Content
        $mform->addElement('textarea', 'config_body', get_string('config_body', 'theme_edma'), 'wrap="virtual" rows="6" cols="50"');

        // Search Placeholder Text
        $mform->addElement('text', 'config_search_placeholder', get_string('config_search_placeholder', 'block_edma_banner_1'));
        $mform->setDefault('config_search_placeholder', 'Search Your Courses...');
        $mform->setType('config_search_placeholder', PARAM_RAW);

        // Search Button Text
        $mform->addElement('text', 'config_search_btn', get_string('config_search_btn', 'block_edma_banner_1'));
        $mform->setDefault('config_search_btn', 'Search Now');
        $mform->setType('config_search_btn', PARAM_RAW);

        $select = $mform->addElement('select', 'config_button_icon', get_string('config_button_icon', 'block_edma_banner_1'), $edmaFontList, array('class'=>'edma_icon_class'));
        $select->setSelected('flaticon-search');

        // Support Text
        $mform->addElement('textarea', 'config_support_text', get_string("config_support_text", "block_edma_banner_1"), 'wrap="virtual" rows="6" cols="50"');

        // Banner Button Text
        $mform->addElement('text', 'config_banner_btn', get_string('config_banner_btn', 'block_edma_banner_1'));
        $mform->setDefault('config_banner_btn', 'View Reviews ');
        $mform->setType('config_banner_btn', PARAM_RAW);

        // Banner Button Link
        $mform->addElement('text', 'config_banner_btn_link', get_string('config_banner_btn', 'block_edma_banner_1'));
        $mform->setDefault('config_banner_btn_link', '#');
        $mform->setType('config_banner_btn_link', PARAM_RAW);

        // Banner Button Icon
        $select = $mform->addElement('select', 'config_banner_btn_icon', get_string('config_banner_btn_icon', 'block_edma_banner_1'), $edmaFontList, array('class'=>'edma_icon_class'));
         $select->setSelected('ri-arrow-right-line');

        // Section Image header title according to language file.
        $mform->addElement('header', 'config_image_heading', get_string('config_image_heading', 'theme_edma'));

        $mform->addElement('static', 'config_image_doc', '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>'); 

        // Banner BG Image
        $mform->addElement('text', 'config_banner_bg_img', 'Banner Background Image ');
        $mform->setType('config_banner_bg_img', PARAM_TEXT);

        // Banner Image
        $mform->addElement('text', 'config_banner_img', 'Banner Image ');
        $mform->setType('config_banner_img', PARAM_TEXT);

        // Support Images
        $support_image_count = 5;
        for($i = 1; $i <= $support_image_count; $i++) {
            $mform->addElement('text', 'config_user_img' . $i, 'Support User Image URL ' . $i);
            $mform->setType('config_user_img' . $i, PARAM_TEXT);
        }

        // Shape Images
        $shape_image_count = 3;
        for($i = 1; $i <= $shape_image_count; $i++) {
            $mform->addElement('text', 'config_shape_img' . $i, 'Banner Shape Image ' . $i);
            $mform->setType('config_shape_img' . $i, PARAM_TEXT);
        }
     
    }
}
