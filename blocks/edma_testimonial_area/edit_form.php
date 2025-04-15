<?php

class block_edma_testimonial_area_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;

        $sliderNumber = 4;
        if(isset($this->block->config->sliderNumber)){
            $sliderNumber = $this->block->config->sliderNumber;
        }

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'Our Students Are Our Strength. See What They Say About Us');
        $mform->setType('config_title', PARAM_RAW);

        // Image URL
        $mform->addElement('static', 'config_image_doc', '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>'); 

        // Section Image
        $mform->addElement('text', 'config_img', 'Section Image URL');
        $mform->setType('config_img', PARAM_TEXT);

        // Section Shape Image
         $mform->addElement('text', 'config_shape_img', 'Shape Image URL');
         $mform->setType('config_shape_img', PARAM_TEXT);

        $sliderrange = array(
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

        $mform->addElement('select', 'config_slider_number', get_string('config_items', 'theme_edma'), $sliderrange);
        $mform->setDefault('config_slider_number', 4);

        for($i = 1; $i <= $sliderNumber; $i++) {
            $mform->addElement('header', 'config_edma_item' . $i , get_string('config_item', 'theme_edma') . $i);

            $mform->addElement('text', 'config_img' . $i, 'Slider Image' . $i);
            $mform->setType('config_img' . $i, PARAM_TEXT);

            // Title
            $mform->addElement('text', 'config_slider_title' . $i, get_string('config_title', 'theme_edma', $i));
            $mform->setDefault('config_slider_title' . $i, 'Great Learning Experience With Edma Team!');
            $mform->setType('config_slider_title' . $i, PARAM_TEXT);

            // Card Content
            $mform->addElement('text', 'config_slider_content' . $i, get_string('config_content', 'theme_edma', $i));
            $mform->setDefault('config_slider_content' . $i, 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.');
            $mform->setType('config_slider_content' . $i, PARAM_TEXT);

            // Card Short Content
            $mform->addElement('text', 'config_slider_bottom_content' . $i, 'Bottom Content', $i);
            $mform->setDefault('config_slider_bottom_content', 'James katliv, <span>Student</span>');
            $mform->setType('config_slider_bottom_content' . $i, PARAM_TEXT);
                
        }
    }
}
