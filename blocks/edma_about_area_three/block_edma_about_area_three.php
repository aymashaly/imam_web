<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_about_area_three extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_about_area_three');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->title = 'Be A Member Of Edma Business & Start Earning Limitless Today';
            $this->config->content = 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.';
            $this->config->button_text = 'Get Edmo Business ';
            $this->config->button_link = $CFG->wwwroot . '/course';
        }
    }

    public function get_content() {
        global $CFG, $USER, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content         =  new stdClass;

        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        
        if(!empty($this->config->content)){$this->content->content = $this->config->content;} else {$this->content->content = '';}

        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;} else {$this->content->button_text = '';}

        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;} else {$this->content->button_link = '';}

        if(isset($this->config->img ) && !empty($this->config->img )){
            $this->content->img  = $this->config->img ;
        }else{
            $this->content->img  = '';
        } 
        
        $text = '';
        $text .= '
        <!-- Start Business Area -->
		<div class="business-area pb-100">
			<div class="container">
				<div class="business-bg rounded bg-color-f2f0ef">
					<div class="row align-items-center">
						<div class="col-lg-7 wow animate__animated animate__fadeInLeft delay-0-2s">
							<div class="business-img">';
                                if($this->content->img):
                                    $img = $this->content->img;
                                    $text .= '<img src="'.edma_block_image_process($img).'" alt="'.$this->content->title.'">';
                                endif;
                                $text .= '
							</div>
						</div>
	
						<div class="col-lg-5 wow animate__animated animate__fadeInRight delay-0-2s">
							<div class="business-content">
                                <h2>'.$this->content->title.'</h2>  
                                <p>'.$this->content->content.'</p>';

                                if(!empty($this->content->button_text) && !empty($this->content->button_link)){
                                    $text .= '
                                    <a href="'.$this->content->button_link.'" class="default-btn">
                                    '.$this->content->button_text.'
                                    </a>';
                                }
                                $text .= '
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Business Area -->';

        $this->content->footer = '';
        $this->content->text   = $text;

        return $this->content;
    }

    function instance_allow_config() {
        return true;
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