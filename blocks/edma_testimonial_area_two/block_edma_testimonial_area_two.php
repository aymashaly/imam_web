<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_testimonial_area_two extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_testimonial_area_two');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->title = 'Our Students Are Our Strength. See What They Say About Us';

            $this->config->slider_title1                = 'Great Learning Experience With Edma Team!';
            $this->config->slider_content1              = 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.';
            $this->config->slider_bottom_content1       = 'Jennifer Watson, <span>Student</span>';

            $this->config->slider_title2          = 'Great Quality Trainer!';
            $this->config->slider_content2        = 'Instructors from around the world teach millions of students on Edma. We provide the top best tools and skills.';
            $this->config->slider_bottom_content2    = 'James katliv, <span>Student</span>';

            $this->config->slider_title3          = 'Great Learning Experience With Edma Team!';
            $this->config->slider_content3        = 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.';
            $this->config->slider_bottom_content3    = 'Jennifer Watson, <span>Student</span>';

            $this->config->slider_title4          = 'Great Quality Trainer!';
            $this->config->slider_content4        = 'Instructors from around the world teach millions of students on Edma. We provide the top best tools and skills.';
            $this->config->slider_bottom_content4    = 'James katliv, <span>Student</span>';

            $this->config->slider_bottom_title1                = 'Great Learning Experience With Edma Team!';
            $this->config->slider_bottom_desc1              = 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.';
            $this->config->slider_bottom_content21       = 'Jennifer Watson, <span>Student</span>';
            
            $this->config->slider_bottom_title2          = 'Great Quality Trainer!';
            $this->config->slider_bottom_desc2        = 'Instructors from around the world teach millions of students on Edma. We provide the top best tools and skills.';
            $this->config->slider_bottom_content22    = 'James katliv, <span>Student</span>';
            
            $this->config->slider_bottom_title3          = 'Great Learning Experience With Edma Team!';
            $this->config->slider_bottom_desc3        = 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.';
            $this->config->slider_bottom_content23    = 'Jennifer Watson, <span>Student</span>';
            
            $this->config->slider_bottom_title4          = 'Great Quality Trainer!';
            $this->config->slider_bottom_desc4        = 'Instructors from around the world teach millions of students on Edma. We provide the top best tools and skills.';
            $this->config->slider_bottom_content24    = 'James katliv, <span>Student</span>';
        }
    }

    public function get_content() {
        global $CFG, $DB;

        $this->content         =  new stdClass;

        $sliderNumber = 4;
        if(isset($this->config->sliderNumber)){
            $sliderNumber = $this->config->sliderNumber;
        }

        // Title
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        $text = '';
        $text .= '
        <!-- Start Testimonial Area -->
		<div class="testimonial-area bg-color-f6fafb pt-100 pb-70">
			<div class="container">
				<div class="section-title">
                    <h2>'. $this->content->title .'</h2>
				</div>
			</div>
			
			<div class="container-fluid">
				<div class="testimonials-slide-list-one owl-carousel owl-theme">';
                    for($i = 1; $i <= $sliderNumber; $i++) {
                        $img                    = 'img' . $i;
                        $slider_title           = 'slider_title' . $i;
                        $slider_content         = 'slider_content' . $i;
                        $slider_bottom_content  = 'slider_bottom_content' . $i;

                        // Image
                        if(isset($this->config->$img)) { $img = $this->config->$img; }else{ $img = ''; }

                        // Title
                        if(isset($this->config->$slider_title)) { $slider_title = $this->config->$slider_title; }else{ $slider_title = ''; }

                        // Content
                        if(isset($this->config->$slider_content)) { $slider_content = $this->config->$slider_content; }else{ $slider_content = ''; }

                        // Bottom Content
                        if(isset($this->config->$slider_bottom_content)) { $slider_bottom_content = $this->config->$slider_bottom_content; }else{ $slider_bottom_content = ''; }

                        
                        $text .= '
                        <div class="single-testimonial">
                            <div class="testimonial-content">
                                <h3>'.$slider_title.'</h3>
                                <p>'.$slider_content.'</p>
                            </div>

                            <div class="testimonial-info d-flex align-items-center">';
                                if($img):
                                    $img = $img;
                                    $text .= '                    
                                    <img class="rounded-pill me-3" src="'.edma_block_image_process($img).'" alt="'.$slider_title.'">';
                                endif;
                                $text .= '
                                
                                <h4 class="mb-0">'.$slider_bottom_content.'</h4>
                            </div>
                        </div>';
                    } $text .= '
				</div>

				<div class="testimonials-slide-list-two owl-carousel owl-theme">';
                    for($i = 1; $i <= $sliderNumber; $i++) {
                        $img                    = 'bottom_img' . $i;
                        $slider_title           = 'slider_bottom_title' . $i;
                        $slider_content         = 'slider_bottom_desc' . $i;
                        $slider_bottom_content  = 'slider_bottom_content2' . $i;

                        // Image
                        if(isset($this->config->$img)) { $img = $this->config->$img; }else{ $img = ''; }

                        // Title
                        if(isset($this->config->$slider_title)) { $slider_title = $this->config->$slider_title; }else{ $slider_title = ''; }

                        // Content
                        if(isset($this->config->$slider_content)) { $slider_content = $this->config->$slider_content; }else{ $slider_content = ''; }

                        // Bottom Content
                        if(isset($this->config->$slider_bottom_content)) { $slider_bottom_content = $this->config->$slider_bottom_content; }else{ $slider_bottom_content = ''; }

                        
                        $text .= '
                        <div class="single-testimonial">
                            <div class="testimonial-content">
                                <h3>'.$slider_title.'</h3>
                                <p>'.$slider_content.'</p>
                            </div>

                            <div class="testimonial-info d-flex align-items-center">';
                                if($img):
                                    $img = $img;
                                    $text .= '                    
                                    <img class="rounded-pill me-3" src="'.edma_block_image_process($img).'" alt="'.$slider_title.'">';
                                endif;
                                $text .= '
                                
                                <h4 class="mb-0">'.$slider_bottom_content.'</h4>
                            </div>
                        </div>';
                    } $text .= '
				</div>
			</div>
		</div>
		<!-- End Testimonial Area -->';
        
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