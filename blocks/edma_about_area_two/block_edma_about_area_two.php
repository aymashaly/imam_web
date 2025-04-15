<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_about_area_two extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_about_area_two');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->title = 'Become An Instructor Today And Start Teaching';
            $this->config->content = 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal with us.';
            $this->config->button_text = 'Become An Instructor ';
            $this->config->button_link = $CFG->wwwroot . '/course';
            
            $this->config->features_title1 = 'Expert Instruction';
            $this->config->features_title2 = 'Lifetime Access';
            $this->config->features_title3 = 'Remote Learning';
            $this->config->features_title4 = 'Self Development';
        }
    }

    public function get_content() {
        global $CFG, $USER, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        if (isset($this->config->items)) {
            $data = $this->config;
            $data->items = is_numeric($data->items) ? (int)$data->items : 8;
        } else {
            $data = new stdClass();
            $data->items = '0';
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

        if(isset($this->config->shape_img ) && !empty($this->config->shape_img )){
            $this->content->shape_img  = $this->config->shape_img ;
        }else{
            $this->content->shape_img  = '';
        } 

        $style = 1;
        if(isset($this->config->style)){
            $style = $this->config->style;
        }

        $text = '';
        if($style == 2):
            $text .= '
            <!-- Start Teaching Area -->
            <div class="teaching-area ptb-100">
                <div class="container">
                    <div class="row align-items-center">
					    <div class="col-lg-6 wow animate__animated animate__fadeInRight delay-0-2s">
                            <div class="teaching-img ml-15">';
                                if($this->content->shape_img):
                                    $shape_img = $this->content->shape_img;
                                    $text .= '<img src="'.edma_block_image_process($shape_img).'" class="teaching-img-shape" alt="'.$this->content->title.'">';
                                endif;
                                if($this->content->img):
                                    $img = $this->content->img;
                                    $text .= '<img src="'.edma_block_image_process($img).'" alt="'.$this->content->title.'">';
                                endif;
                                $text .= '
                            </div>
                        </div>

                        <div class="col-lg-6 wow animate__animated animate__fadeInLeft delay-0-2s">
                            <div class="teaching-content mr-15">
                                <h2>'.$this->content->title.'</h2>  
                                <p>'.$this->content->content.'</p>

                                <div class="row">';
                                    if ($data->items > 0) {
                                        for ($i = 1; $i <= $data->items; $i++) {
                                            $img                    = 'img' . $i;
                                            $features_title         = 'features_title' . $i;
                    
                                            // Image
                                            if(isset($this->config->$img)) { $img = $this->config->$img; }else{ $img = ''; }
                    
                                            // Title
                                            if(isset($this->config->$features_title)) { $features_title = $this->config->$features_title; }else{ $features_title = ''; }
                                            if($i % 2 != 0){
                                                $text .= '<ul>';
                                            }
                                            $text .= '
                                                <li class="d-flex align-items-center">';
                                                    if($img):
                                                        $img = $img;
                                                        $text .= '                    
                                                        <img src="'.edma_block_image_process($img).'" alt="'.$features_title.'">';
                                                    endif;
                                                    $text .= '
                                                    <h3>'.$features_title.'</h3>
                                                </li>';
                                            if($i % 2 == 0){
                                                $text .= '</ul>';
                                            }
                                        }
                                    }
                                    $text .= '
                                </div>

                                ';
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
            <!-- End Teaching Area -->';
        else:
            $text .= '
            <!-- Start Teaching Area -->
            <div class="teaching-area ptb-100">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 wow animate__animated animate__fadeInLeft delay-0-2s">
                            <div class="teaching-content mr-15">
                                <h2>'.$this->content->title.'</h2>  
                                <p>'.$this->content->content.'</p>

                                <div class="row">';
                                    if ($data->items > 0) {
                                        for ($i = 1; $i <= $data->items; $i++) {
                                            $img                    = 'img' . $i;
                                            $features_title         = 'features_title' . $i;
                    
                                            // Image
                                            if(isset($this->config->$img)) { $img = $this->config->$img; }else{ $img = ''; }
                    
                                            // Title
                                            if(isset($this->config->$features_title)) { $features_title = $this->config->$features_title; }else{ $features_title = ''; }
                                            if($i % 2 != 0){
                                                $text .= '<ul>';
                                            }
                                            $text .= '
                                                <li class="d-flex align-items-center">';
                                                    if($img):
                                                        $img = $img;
                                                        $text .= '                    
                                                        <img src="'.edma_block_image_process($img).'" alt="'.$features_title.'">';
                                                    endif;
                                                    $text .= '
                                                    <h3>'.$features_title.'</h3>
                                                </li>';
                                            if($i % 2 == 0){
                                                $text .= '</ul>';
                                            }
                                        }
                                    }
                                    $text .= '
                                </div>

                                ';
                                if(!empty($this->content->button_text) && !empty($this->content->button_link)){
                                    $text .= '
                                    <a href="'.$this->content->button_link.'" class="default-btn">
                                    '.$this->content->button_text.'
                                    </a>';
                                }
                                $text .= '
                            </div>
                        </div>

                        <div class="col-lg-6 wow animate__animated animate__fadeInRight delay-0-2s">
                            <div class="teaching-img ml-15">';
                                if($this->content->shape_img):
                                    $shape_img = $this->content->shape_img;
                                    $text .= '<img src="'.edma_block_image_process($shape_img).'" class="teaching-img-shape" alt="'.$this->content->title.'">';
                                endif;
                                if($this->content->img):
                                    $img = $this->content->img;
                                    $text .= '<img src="'.edma_block_image_process($img).'" alt="'.$this->content->title.'">';
                                endif;
                                $text .= '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Teaching Area -->';
        endif;

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