<?php

class block_edma_about_area_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Class
        $mform->addElement('text', 'config_class', get_string('config_class', 'theme_edma'));
        $mform->setDefault('config_class', '​');
        $mform->setType('config_class', PARAM_RAW);

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Transform Your Life Through Online Education​');
        $mform->setType('config_title', PARAM_RAW);

        // Content
        $mform->addElement('textarea', 'config_body', get_string('config_body', 'theme_edma'), 'wrap="virtual" rows="6" cols="50"');
        $mform->setDefault('config_body', 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal​');
        $mform->setType('config_body', PARAM_RAW);

        //  Button Text
        $mform->addElement('text', 'config_btn', get_string('config_button_text', 'theme_edma'));
        $mform->setDefault('config_btn', 'Find Out How');
        $mform->setType('config_btn', PARAM_RAW);

        //  Button Link
        $mform->addElement('text', 'config_btn_link', get_string('config_button_link', 'theme_edma'));
        $mform->setDefault('config_btn_link', '#');
        $mform->setType('config_btn_link', PARAM_RAW);

        //  Video Link
        $mform->addElement('text', 'config_video', get_string('config_video', 'theme_edma'));
        $mform->setDefault('config_video', 'https://www.youtube.com/watch?v=_aB9Tg6SRA0');
        $mform->setType('config_video', PARAM_RAW);

        $mform->addElement('text', 'config_video_img', 'Video Image URL');
        $mform->setType('config_video_img', PARAM_TEXT);

        //  Video Title Text
        $mform->addElement('text', 'config_video_title', 'Video Title');
        $mform->setDefault('config_video_title', 'Watch Video From the Community How Edma Change Their Life');
        $mform->setType('config_video_title', PARAM_RAW);

        //  Student Name Text
        $mform->addElement('text', 'config_student_name', 'Video Student Name');
        $mform->setDefault('config_student_name', 'Victor james,');
        $mform->setType('config_student_name', PARAM_RAW);

        //  Student Content Text
        $mform->addElement('text', 'config_student_content', 'Video Student Content');
        $mform->setDefault('config_student_content', 'Edma’s Student');
        $mform->setType('config_student_content', PARAM_RAW);

        // Section Image header title according to language file.
        $mform->addElement('header', 'config_image_heading', get_string('config_image_heading', 'theme_edma'));

        $mform->addElement('static', 'config_image_doc', '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>');
            
        $mform->addElement('text', 'config_img', get_string('config_image', 'theme_edma'));
        $mform->setType('config_img', PARAM_TEXT);
    }
}
