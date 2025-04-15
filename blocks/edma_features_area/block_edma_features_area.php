<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_features_area extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_features_area');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->top_title = 'Our Features';
            $this->config->title = 'Why You Should Choose Edma';

            $this->config->features_title1          = 'Expert-Led Video Courses';
            $this->config->features_content1        = 'Instructors from around the world teach millions of students on Edma through video.';
            $this->config->features_button_link1    = $CFG->wwwroot . '/course';

            $this->config->features_title2          = 'In-Demand Trendy Topics';
            $this->config->features_content2        = 'Instructors from around the world teach millions of students on Edma through video.';
            $this->config->features_button_link2    = $CFG->wwwroot . '/course';

            $this->config->features_title3          = 'Segment Your Learning';
            $this->config->features_content3        = 'Instructors from around the world teach millions of students on Edma through video.';
            $this->config->features_button_link3    = $CFG->wwwroot . '/course';

            $this->config->features_title4          = 'Always Interactive Learning';
            $this->config->features_content4        = 'Instructors from around the world teach millions of students on Edma through video.';
            $this->config->features_button_link4    = $CFG->wwwroot . '/course';
        }
    }

    public function get_content() {
        global $CFG, $DB;

        $this->content         =  new stdClass;

        $features_number = 4;
        if(isset($this->config->features_number)){
            $features_number = $this->config->features_number;
        }

        // Title
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}

        // Top Title
        if(!empty($this->config->top_title)){$this->content->top_title = $this->config->top_title;} else {$this->content->top_title = '';}
       
        if(isset($this->config->shape_img ) && !empty($this->config->shape_img )){
            $this->content->shape_img  = $this->config->shape_img ;
        }else{
            $this->content->shape_img  = '';
        }   

        $text = '';
        $text .= '
        <!-- End Our Features Area -->
		<div class="our-features-area bg-color-f1efee pt-100 pb-70">
			<div class="container">
				<div class="section-title wow animate__animated animate__fadeInUp delay-0-2s">
					<span class="top-title">'. $this->content->top_title .'</span>
                    <h2>'. $this->content->title .'</h2>
				</div>

				<div class="row justify-content-center">';
                    for($i = 1; $i <= $features_number; $i++) {
                        $img                    = 'img' . $i;
                        $features_title         = 'features_title' . $i;
                        $features_content       = 'features_content' . $i;
                        $features_button_link   = 'features_button_link' . $i;

                        // Image
                        if(isset($this->config->$img)) { $img = $this->config->$img; }else{ $img = ''; }

                        // Title
                        if(isset($this->config->$features_title)) { $features_title = $this->config->$features_title; }else{ $features_title = ''; }

                        // Content
                        if(isset($this->config->$features_content)) { $features_content = $this->config->$features_content; }else{ $features_content = ''; }

                        // Button Link
                        if(isset($this->config->$features_button_link)) { $features_button_link = $this->config->$features_button_link; }else{ $features_button_link = ''; }
                        $text .= '
                        <div class="col-lg-3 col-sm-6 wow animate__animated animate__fadeInUp delay-0-2s">
                            <div class="single-features">';
                                if($img):
                                    $img = $img;
                                    $text .= '                    
                                    <img src="'.edma_block_image_process($img).'" alt="'.$features_title.'">';
                                endif;
                                $text .= '
                                <h3>'.$features_title.'</h3>

                                <div class="features-link">
                                    <p>'.$features_content.'</p>';
                                    if($features_button_link):
                                        $text .= '
                                        <a href="'.$features_button_link.'" class="features-btn">
                                            <i class="ri-arrow-right-s-line"></i>
                                        </a>';
                                    endif;
                                    $text .= '
                                </div>
                            </div>
                        </div>';
                    } $text .= '
				</div>
			</div>';

            if($this->content->shape_img):
                $shape_img = $this->content->shape_img;
                $text .= '<img src="'.edma_block_image_process($shape_img).'" class="shape shape-1" alt="'.$this->content->title.'">';
            endif;
            $text .= '
		</div>
		<!-- End Our Features Area -->';
        
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