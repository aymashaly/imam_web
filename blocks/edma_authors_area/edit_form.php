<?php

class block_edma_authors_area_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;

        $author_number = 4;
        if(isset($this->block->config->author_number)){
            $author_number = $this->block->config->author_number;
        }

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

         // Title
         $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
         $mform->setDefault('config_title', 'Why You Should Choose Edma');
         $mform->setType('config_title', PARAM_RAW);

        // Content
        $mform->addElement('text', 'config_body', get_string('config_body', 'theme_edma'));
        $mform->setDefault('config_body', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Convallis vel feugiat dolor nam ullamcorper.');
        $mform->setType('config_body', PARAM_RAW);

        $authorrange = array(
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

        $mform->addElement('select', 'config_author_number', get_string('config_items', 'theme_edma'), $authorrange);
        $mform->setDefault('config_author_number', 4);

        for($i = 1; $i <= $author_number; $i++) {
            $mform->addElement('header', 'config_edma_item' . $i , get_string('config_item', 'theme_edma') . $i);

            // Image URL
            $mform->addElement('static', 'config_image_doc' . $i, '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>'); 

            $mform->addElement('text', 'config_img' . $i, 'Author Image' . $i);
            $mform->setType('config_img' . $i, PARAM_TEXT);

            // Title
            $mform->addElement('text', 'config_author_title' . $i, get_string('config_title', 'theme_edma', $i));
            $mform->setDefault('config_author_title' . $i, 'Adam Smith');
            $mform->setType('config_author_title' . $i, PARAM_TEXT);

            // Card Content
            $mform->addElement('text', 'config_author_content' . $i, get_string('config_content', 'theme_edma', $i));
            $mform->setDefault('config_author_content' . $i, 'Illustrator');
            $mform->setType('config_author_content' . $i, PARAM_TEXT);

            // Card Button Link
            $mform->addElement('text', 'config_author_button_link' . $i, get_string('config_button_link', 'theme_edma', $i));
            $mform->setDefault('config_author_button_link', $CFG->wwwroot . '/course');
            $mform->setType('config_author_button_link' . $i, PARAM_TEXT);
                
        }
    }
}
