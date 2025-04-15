<?php
global $CFG;
class block_edma_faq extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_faq');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->top_title = 'FAQ';
            $this->config->title = 'We Are Always Ready To Help You';
            $this->config->tabNumber = '2';
            $this->config->tab_title1 = 'Students';
            $this->config->tab_title2 = 'Instructor';
            $this->config->tab_content1 = '
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        How To Book Online Appoinment?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Egestas facilisis metus vitae mattis velit ac amet, mattis an Quam eu aliquam quisque commodo feugiat placerat elit. Eget mi, morbi tincidunt dolor. Placerat enim rid iculus idemer feugiat faucibus non pulvinar tincidunt. Vulputate tincidunt sed interdum interdum porta enim.</p>
                    </div>
                </div>
            </div>';
            $this->config->tab_content2 = '
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        How To Book Online Appoinment?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-parent="#accordionExample2" style="">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Egestas facilisis metus vitae mattis velit ac amet, mattis an Quam eu aliquam quisque commodo feugiat placerat elit. Eget mi, morbi tincidunt dolor. Placerat enim rid iculus idemer feugiat faucibus non pulvinar tincidunt. Vulputate tincidunt sed interdum interdum porta enim.</p>
                    </div>
                </div>
            </div>';
        }
    }

    public function get_content() {
        global $CFG, $DB;

        if ($this->content !== null) {
            return $this->content;
        }
  
        $this->content         =  new stdClass;

        if(!empty($this->config->top_title)){
            $this->content->top_title = $this->config->top_title;
        }else{
            $this->content->top_title = '';
        }

        if(!empty($this->config->title)){
            $this->content->title = $this->config->title;
        }else{
            $this->content->title = '';
        }

        $tabNumber = 2;
        if(isset($this->config->tabNumber)){
            $tabNumber = $this->config->tabNumber;
        }

        if(isset($this->config->shape_img ) && !empty($this->config->shape_img )){
            $this->content->shape_img  = $this->config->shape_img ;
        }else{
            $this->content->shape_img  = '';
        } 

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

       
        $text = '';
        $text .= '

        <!-- Start FAQ Area -->
		<div class="faq-area bg-color-ffffff ptb-100">
			<div class="container">
				<div class="section-title">
					<span class="top-title">'.$this->content->top_title.'</span>
					<h2>'.$this->content->title.'</h2>
				</div>
				
                <ul class="faq-tab nav nav-tabs justify-content-between" id="myTab" role="tablist">';
                    for($i = 1; $i <= $tabNumber; $i++) {
                        $tab_title = 'tab_title' . $i;

                        if(isset($this->config->$tab_title)) {
                            $tab_title = $this->config->$tab_title;
                        }else{
                            $tab_title = '';
                        } 
                        if($i == 1):
                            $text .= '
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="list-'.$i.'-tab" data-toggle="tab" href="#list-'.$i.'" role="tab" aria-controls="list-'.$i.'" aria-selected="true">'.$tab_title.'</a>
                            </li>';
                        else:
                            $text .= '
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="list-'.$i.'-tab" data-toggle="tab" href="#list-'.$i.'" role="tab" aria-controls="list-'.$i.'" aria-selected="false">'.$tab_title.'</a>
                            </li>';
                        endif;
                    }
                    $text .= '
				</ul>
				<div class="tab-content" id="myTabContent">';
                    for($i = 1; $i <= $tabNumber; $i++) {
                        $tab_title      = 'tab_title' . $i;
                        $tab_content    = 'tab_content' . $i;

                        if(isset($this->config->$tab_title)) {
                            $tab_title = $this->config->$tab_title;
                        }else{
                            $tab_title = '';
                        }

                        if(isset($this->config->$tab_content)) {
                            $tab_content = $this->config->$tab_content;
                        }else{
                            $tab_content = '';
                        }
                        
                        if($i == 1):
                            $text .= '
                            <div class="tab-pane fade show active" id="list-'.$i.'" role="tabpanel" aria-labelledby="list-'.$i.'-tab">
                                <div class="accordion" id="accordionExample">
                                    <div class="faq-content">
                                        '.$tab_content.'
                                    </div>
                                </div>
                            </div>';
                        else:
                            $text .= '
                            <div class="tab-pane fade" id="list-'.$i.'" role="tabpanel" aria-labelledby="list-'.$i.'-tab">
                                <div class="accordion" id="accordionExample'.$i.'">
                                    <div class="faq-content">
                                        '.$tab_content.'
                                    </div>
                                </div>
                            </div>';
                        endif;
                    }
                    $text .= '
				</div>
			</div>';
            if($this->content->shape_img):
                $shape_img = $this->content->shape_img;
                $text .= '<img src="'.edma_block_image_process($shape_img).'" class="shape shape-1" alt="'.$this->content->title.'">';
            endif;
            $text .= '
		</div>
		<!-- End FAQ Area -->';
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