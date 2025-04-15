<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_contact extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_contact');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->title = 'Send Us Message Anytime';
            $this->config->subtitle = 'Contact Us';
        }
    }

    public function get_content() {
        global $CFG, $DB;

        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        
        if(!empty($this->config->img)){$this->content->img = $this->config->img;} else {$this->content->img = '';}

        if(!empty($this->config->img2)){$this->content->img2 = $this->config->img2;} else {$this->content->img2 = '';}
        
        if(!empty($this->config->contact_from_code)){$this->content->contact_from_code = $this->config->contact_from_code;} else {$this->content->contact_from_code = '';}
        $text = '';
        $text .= '
        <!-- Start Contact Area -->
		<div class="contact-area pb-100">
			<div class="container">
				<div class="section-title">
					<span class="top-title">'.$this->content->subtitle.'</span>
					<h2>'.$this->content->title.'</h2>
				</div>

				<div class="contact-form">
                    '.$this->content->contact_from_code.'
				</div>
			</div>';

            if($this->content->img):
                $img = $this->content->img;
                $text .= '
                <img src="'.edma_block_image_process($img).'" class="shape shape-1" alt="'.$this->content->title.'">';
            endif;

            if($this->content->img2):
                $img2 = $this->content->img2;
                $text .= '
                <img src="'.edma_block_image_process($img2).'" class="shape shape-2" alt="'.$this->content->title.'">';
            endif;
            $text .= '
		</div>
		<!-- End Contact Area -->';

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