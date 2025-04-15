<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_about_area extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_about_area');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->title = 'Transform Your Life Through Online Education​';
            $this->config->body = 'Instructors from around the world teach millions of students on Edma. We provide the tools and skills to teach what you love. And you can also achieve your goal.';
            $this->config->btn = 'Find Out How';
            $this->config->btn_link = '#';
            $this->config->video_title = 'Watch Video From the Community How Edma Change Their Life';
            $this->config->video = 'https://www.youtube.com/watch?v=_aB9Tg6SRA0';
            $this->config->student_name = 'Victor james';
            $this->config->student_content = 'Edma’s Student';
            $this->config->class = '';
        }
    }

    public function get_content() {
        global $CFG, $DB;

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

        if(isset($this->config->class) && !empty($this->config->class)){
            $this->content->class = $this->config->class;
        }else{
            $this->content->class = '';
        }

        if(isset($this->config->btn) && !empty($this->config->btn)){
            $this->content->btn = $this->config->btn;
        }else{
            $this->content->btn = '';
        }

        if(isset($this->config->btn_link) && !empty($this->config->btn_link)){
            $this->content->btn_link = $this->config->btn_link;
        }else{
            $this->content->btn_link = '';
        }

        if(isset($this->config->video_title) && !empty($this->config->video_title)){
            $this->content->video_title = $this->config->video_title;
        }else{
            $this->content->video_title = '';
        }

        if(isset($this->config->student_name) && !empty($this->config->student_name)){
            $this->content->student_name = $this->config->student_name;
        }else{
            $this->content->student_name = '';
        }

        if(isset($this->config->student_content) && !empty($this->config->student_content)){
            $this->content->student_content = $this->config->student_content;
        }else{
            $this->content->student_content = '';
        }

        if(isset($this->config->video) && !empty($this->config->video)){
            $this->content->video = $this->config->video;
        }else{
            $this->content->video = '';
        }

        if(isset($this->config->img) && !empty($this->config->img)){
            $this->content->img = $this->config->img;
        }else{
            $this->content->img = '';
        }  

        if(isset($this->config->video_img ) && !empty($this->config->video_img )){
            $this->content->video_img  = $this->config->video_img ;
        }else{
            $this->content->video_img  = '';
        }        
        $text = '';
        $text .= '
        <!-- Start About Area -->
		<div class="transform-area pb-100 '.$this->content->class.'">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 wow animate__animated animate__fadeInLeft delay-0-2s">
						<div class="transform-conetnt wow animate__animated animate__fadeInLeft delay-0-8s">
                            <h2>'.$this->content->title.'</h2>
                            <p>'.$this->content->body.'</p>';

                            if($this->content->video_title):
                                $text .='
                                <div class="single-transform d-flex align-items-center">
                                    <div class="transform-video-img flex-shrink-0">';
                                        if($this->content->video_img):
                                            $video_img = $this->content->video_img;
                                            $text .= '<img src="'.edma_block_image_process($video_img).'" alt="'.$this->content->video_title.'">';
                                        endif;
                                        $text .= '

                                        <a href="'.$this->content->video.'" class="video-btns popup-youtube">
                                            <i class="ri-play-circle-fill"></i>
                                        </a>
                                    </div>

                                    <div class="transform-video-content flex-grow-1">
                                        <h3>
                                            <a href="'.$this->content->video.'" class="popup-youtube">'.$this->content->video_title.'</a>
                                        </h3>
                                        
                                        <ul>
                                            <li>
                                                <div class="active">'.$this->content->student_name.'</div>
                                            </li>
                                            <li>
                                            '.$this->content->student_content.'
                                            </li>
                                        </ul>
                                    </div>
                                </div>';
                            endif;
                                
                            if($this->content->btn): $text .= '
                                <a href="'.$this->content->btn_link.'" class="default-btn"> '.$this->content->btn.'</a>'; 
                            endif;  $text .= '
						</div>
					</div>';

                    if($this->content->img):
                        $img = $this->content->img;
                        $text .= '
                        <div class="col-lg-6 wow animate__animated animate__fadeInRight delay-0-2s">
                            <div class="transform-img wow animate__animated animate__fadeInRight delay-0-8s">
                                <img src="'.edma_block_image_process($img).'" alt="'.$this->content->title.'">
                            </div>
                        </div>
                        ';
                    endif;
                    $text .= '
				</div>
			</div>
		</div>
		<!-- End About Area --> ';
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