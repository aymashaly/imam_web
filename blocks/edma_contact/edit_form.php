<?php

class block_edma_contact_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edma'));
        $mform->setDefault('config_subtitle', 'Contact Us');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Send Us Message Anytime');
        $mform->setType('config_title', PARAM_RAW);

        $mform->addElement('textarea', 'config_contact_from_code', get_string('config_contact_from_code', 'theme_edma'), 'wrap="virtual" rows="10" cols="50"');

        $mform->addElement('static', 'config_cotact_doc', '<b><a style="color: var(--primaryColor)" href="https://moodle.org/plugins/local_contact" target="_blank">Please make sure this plugin is installed.</a></b>'); 

        // Image
        $mform->addElement('text', 'config_img', 'Contact Shape Image URL');
        $mform->setType('config_img', PARAM_TEXT);

        // Image 2
        $mform->addElement('text', 'config_img2', 'Contact Shape Image Two URL');
        $mform->setType('config_img2', PARAM_TEXT);

        $mform->addElement('static', 'config_image_doc', '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>');
    }
}
