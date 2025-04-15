<?php

class block_edma_faq_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        global $CFG;

        $tabNumber = 2;
        if(isset($this->block->config->tabNumber)){
            $tabNumber = $this->block->config->tabNumber;
        }

        $faqnumber = 3;
        if(isset($this->block->config->faqnumber)){
            $faqnumber = $this->block->config->faqnumber;
        }

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Top Title
        $mform->addElement('text', 'config_top_title', get_string('config_top_title', 'theme_edma'));
        $mform->setDefault('config_top_title', 'FAQ');
        $mform->setType('config_top_title', PARAM_RAW);

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edma'));
        $mform->setDefault('config_title', 'We Are Always Ready To Help You');
        $mform->setType('config_title', PARAM_RAW);

        // Shape Image
        $mform->addElement('text', 'config_shape_img', 'Section Shape Image URL');
        $mform->setType('config_shape_img', PARAM_TEXT);

        // Image URL
        $mform->addElement('static', 'config_image_doc', '<b><a style="color: var(--primaryColor)" href="https://docs.envytheme.com/docs/edma-moodle-theme-documentation/faqs/how-to-get-the-image-url/" target="_blank">Doc link: How to make Image URL?</a></b>'); 

        $faqrange = array(
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

        $mform->addElement('select', 'config_tabNumber', 'Tab Number', $faqrange);
        $mform->setDefault('config_tabNumber', 2);

        for($i = 1; $i <= $tabNumber; $i++) {
            $mform->addElement('header', 'config_edma_tab_item' . $i , 'Tab Item ' . $i);

            $mform->addElement('text', 'config_tab_title' . $i, 'Tab Title' . $i);
            $mform->setDefault('config_faq_title' . $i, 'Student');
            $mform->setType('config_faq_title' . $i, PARAM_TEXT);
        
            $mform->addElement('textarea', 'config_tab_content' . $i, 'Faq Content' . $i, 'wrap="virtual" rows="10" cols="50"');
            $mform->setDefault('config_tab_content' . $i, '
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        How To Book Online Appoinment?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Egestas facilisis metus vitae mattis velit ac amet, mattis an Quam eu aliquam quisque commodo feugiat placerat elit. Eget mi, morbi tincidunt dolor. Placerat enim rid iculus idemer feugiat faucibus non pulvinar tincidunt. Vulputate tincidunt sed interdum interdum porta enim.</p>
                    </div>
                </div>
            </div>');
            $mform->setType('config_tab_content' . $i, PARAM_RAW);
        }
    }
}
