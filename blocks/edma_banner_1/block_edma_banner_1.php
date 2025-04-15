<?php
global $CFG;
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_banner_1 extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_banner_1');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->title = 'Improve Your Online Learning Experience Better Instantly';
            $this->config->body = 'We have <span>40k+</span> Online courses &amp; <span>600+</span> Online registered student. Find your desired Courses from them.';
            $this->config->support_text = '600+ People already trusted us.';
            $this->config->banner_btn = 'View Reviews';
            $this->config->banner_btn_link = '#';
            $this->config->search_placeholder = 'Search Your Courses...';
            $this->config->search_btn = 'Search Now';
        }
    }

    public function get_content() {
        global $CFG, $DB;

        $btn_img_url = new moodle_url('/theme/edma/pix/search-normal.svg');

        if ($this->content !== null) {
          return $this->content;
        }

        $this->content         =  new stdClass;
        if(!empty($this->config->title)){
            $this->content->title = $this->config->title;
        }else{
            $this->content->title = '';
        }
        if(isset($this->config->body) && !empty($this->config->body)){
            $this->content->body = $this->config->body;
        }else{
            $this->content->body = '';
        }

        if (\core_search\manager::is_global_search_enabled() === false) {
            $this->content->search_placeholder = 'Global searching is not enabled.';
        }else{
            if(isset($this->config->search_placeholder) && !empty($this->config->search_placeholder)){
                $this->content->search_placeholder = $this->config->search_placeholder;
            }else{
                $this->content->search_placeholder = '';
            }
        }

        $url = new moodle_url('/search/index.php');

        if(isset($this->config->search_btn) && !empty($this->config->search_btn)){
            $this->content->search_btn = $this->config->search_btn;
        }else{
            $this->content->search_btn = '';
        }

        if(isset($this->config->button_icon) && !empty($this->config->button_icon)){
            $this->content->button_icon = $this->config->button_icon;
        }else{
            $this->content->button_icon = '';
        }

        if(isset($this->config->support_text) && !empty($this->config->support_text)){
            $this->content->support_text = $this->config->support_text;
        }else{
            $this->content->support_text = '';
        }

        if(isset($this->config->banner_btn) && !empty($this->config->banner_btn)){
            $this->content->banner_btn = $this->config->banner_btn;
        }else{
            $this->content->banner_btn = '';
        }

        if(isset($this->config->banner_btn_link) && !empty($this->config->banner_btn_link)){
            $this->content->banner_btn_link = $this->config->banner_btn_link;
        }else{
            $this->content->banner_btn_link = '';
        }

        if(isset($this->config->banner_btn_icon) && !empty($this->config->banner_btn_icon)){
            $this->content->banner_btn_icon = $this->config->banner_btn_icon;
        }else{
            $this->content->banner_btn_icon = '';
        }

        $banner_bg_img = 'banner_bg_img';
        if(isset($this->config->$banner_bg_img) && !empty($this->config->$banner_bg_img)){
            $this->content->$banner_bg_img = $this->config->$banner_bg_img;
        }else{
            $this->content->$banner_bg_img = '';
        }

        if($this->content->banner_bg_img):
            $banner_bg_img = $this->content->banner_bg_img;
        else:
            $banner_bg_img = '';
        endif;

        $banner_img = 'banner_img';
        if(isset($this->config->$banner_img) && !empty($this->config->$banner_img)){
            $this->content->$banner_img = $this->config->$banner_img;
        }else{
            $this->content->$banner_img = '';
        }

        $shape_image_count = 3;
        for($i = 1; $i <= $shape_image_count; $i++) {
            $shape_img = 'shape_img' .$i;
            if(isset($this->config->$shape_img) && !empty($this->config->$shape_img)){
                $this->content->$shape_img = $this->config->$shape_img;
            }else{
                $this->content->$shape_img = '';
            }
        }
        
        $text = '';
        $text .= '
        <!-- Start Banner Area -->
		<div class="banner-area bg-1" style="background-image:url('.edma_block_image_process($banner_bg_img).');">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="banner-img wow animate__animated animate__fadeInUp delay-0-2s">';
                            if($this->content->banner_img):
                                $banner_img = $this->content->banner_img;
                                $text .= '
                                <div class="image">
                                    <img src="'.edma_block_image_process($banner_img).'" alt="'.$this->content->title.'">
                                </div>';
                            endif;
                            $text .= '
						</div>
					</div>

					<div class="col-lg-6">
						<div class="banner-content">
							<h1 class="wow animate__animated animate__fadeInUp delay-0-2s">'.$this->content->title.'</h1>
							<p class="wow animate__animated animate__fadeInUp delay-0-4s">'.$this->content->body.'</p>';

                            if($this->content->search_placeholder):
                                $text .= '
                                <form class="search-form wow animate__animated animate__fadeInUp delay-0-6s" action="'.$url->out().'">
                                    <input type="text" name="q" class="form-control" placeholder="'.$this->content->search_placeholder.'">
                                    <button class="default-btn" type="submit">
                                        <span>'.$this->content->search_btn.'</span>';
                                        if($this->content->button_icon):
                                            $text .='
                                            <i class="'.$this->content->button_icon.'"></i>';
                                        else:
                                            $text .='
                                            <img src="'.$btn_img_url.'" alt="'.$this->content->search_btn.'">';
                                        endif;
                                        $text .='
                                    </button>
                                </form>';
                            endif;
                            $text .= '

							<ul class="client-list wow animate__animated animate__fadeInUp delay-0-8s">
								<li>';
                                    $support_image_count = 5;
                                    for($i = 1; $i <= $support_image_count; $i++) {
                                        $user_img = 'user_img' .$i;
                                        if(isset($this->config->$user_img) && !empty($this->config->$user_img)){
                                            $user_img = $this->config->$user_img;
                                            $text .= '<img src="'.edma_block_image_process($user_img).'" alt="'.$this->content->title.'">';
                                        }
                                    }
                                    $text .= '
								</li>';

                                if($this->content->support_text): $text .= '
                                    <li>
                                        <p>'.$this->content->support_text.' ';
                                            if($this->content->banner_btn): $text .= '
                                                <a href="'.$this->content->banner_btn_link.'" class="read-more">'.$this->content->banner_btn.' <i class="'.$this->content->banner_btn_icon.'"></i></a>'; 
                                            endif;  
                                            $text .= '
                                        </p>
                                    </li>'; 
                                endif; 
                                $text .= '
							</ul>
						</div>
					</div>
				</div>
			</div>';
            
            if($this->content->shape_img1):
                $shape_img1 = $this->content->shape_img1;
                $text .= '                    
                <img src="'.edma_block_image_process($shape_img1).'" class="shape shape-1" alt="'.$this->content->title.'">';
            endif;
            if($this->content->shape_img2):
                $shape_img2 = $this->content->shape_img2;
                $text .= '                    
                <img src="'.edma_block_image_process($shape_img2).'" class="shape shape-2" alt="'.$this->content->title.'">';
            endif;
            if($this->content->shape_img3):
                $shape_img3 = $this->content->shape_img3;
                $text .= '
                <img src="'.edma_block_image_process($shape_img3).'" class="shape shape-3" alt="'.$this->content->title.'">';
            endif;
            $text .= '
		</div>
		<!-- End Banner Area -->';

        $this->content         =  new stdClass;
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