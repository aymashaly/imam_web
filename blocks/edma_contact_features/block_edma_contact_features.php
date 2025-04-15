<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_contact_features extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_contact_features');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->features_title1          = 'Call Us';
            $this->config->features_content1        = '
            <ul>
                <li>
                    <a href="tel:+009-3867-321">+009 3867 321</a>
                </li>
                <li>
                    <a href="tel:+009-3867-532">+009 3867 532</a>
                </li>
            </ul>';

            $this->config->features_title2          = 'Mail Us';
            $this->config->features_content2        = '
            <ul>
                <li>
                    <a href="mailto:hello@edma.com">hello@edma.com</a>
                </li>
                <li>
                    <a href="mailto:info@edma.com">info@edma.com</a>
                </li>
            </ul>';

            $this->config->features_title3          = 'Visit Us';
            $this->config->features_content3        = '<p>Cecilia Chapman, 711-2880 Nulla St. Mississippi 96522</p>';
        }
    }

    public function get_content() {
        global $CFG, $DB;

        $this->content         =  new stdClass;

        $features_number = 3;
        if(isset($this->config->features_number)){
            $features_number = $this->config->features_number;
        }

        $text = '';
        $text .= '
        <!-- Start Contact Info Area -->
		<div class="contact-info-area pt-100 pb-70">
			<div class="container">
				<div class="row justify-content-center">';
                    for($i = 1; $i <= $features_number; $i++) {
                        $img                    = 'img' . $i;
                        $features_title         = 'features_title' . $i;
                        $features_content       = 'features_content' . $i;

                        // Image
                        if(isset($this->config->$img)) { $img = $this->config->$img; }else{ $img = ''; }

                        // Title
                        if(isset($this->config->$features_title)) { $features_title = $this->config->$features_title; }else{ $features_title = ''; }

                        // Content
                        if(isset($this->config->$features_content)) { $features_content = $this->config->$features_content; }else{ $features_content = ''; }
                        $text .= '
                        <div class="col-lg-4 col-md-6">';
                            if($i == 2):
                                $text .= '<div class="single-contact-info bg-f3dfc1 d-flex align-items-center">';
                            elseif($i == 3):
                                $text .= '<div class="single-contact-info bg-a8e3da d-flex align-items-center">';
                            else:
                                $text .= '<div class="single-contact-info d-flex align-items-center">';
                            endif;
                                if($img):
                                    $img = $img;
                                    $text .= '                    
                                    <img src="'.edma_block_image_process($img).'" alt="'.$features_title.'">';
                                endif;
                                $text .= '
    
                                <div>
                                    <h3>'.$features_title.'</h3>
                                    '.$features_content.'
                                </div>
                            </div>
                        </div>';
                    } $text .= '

				</div>
			</div>
		</div>
		<!-- End Contact Info Area -->';
        
        $this->content->footer = '';
        $this->content->text   = $text;

        return $this->content;
    }

    /**
     * The block can be used repeatedly in a page.
     */
    function instance_allow_multiple() {
        return true;
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    function has_config() {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    function applicable_formats() {
        return array(
            'all' => true,
            'my' => false,
            'admin' => false,
            'course-view' => true,
            'course' => true,
        );
    }

}