<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_authors_area extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_authors_area');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->body = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Convallis vel feugiat dolor nam ullamcorper.';
            $this->config->title = 'Classes Taught By Real Creators';

            $this->config->author_title1          = 'Adam Smith';
            $this->config->author_content1        = 'Illustrator';
            $this->config->author_button_link1    = $CFG->wwwroot . '/course';

            $this->config->author_title2          = 'Jane Ronan';
            $this->config->author_content2        = 'Writer';
            $this->config->author_button_link2    = $CFG->wwwroot . '/course';

            $this->config->author_title3          = 'John Karahan';
            $this->config->author_content3        = 'Developer';
            $this->config->author_button_link3    = $CFG->wwwroot . '/course';

            $this->config->author_title4          = 'Willina Bena';
            $this->config->author_content4        = 'Designer';
            $this->config->author_button_link4    = $CFG->wwwroot . '/course';
        }
    }

    public function get_content() {
        global $CFG, $DB;

        $this->content         =  new stdClass;

        $author_number = 4;
        if(isset($this->config->author_number)){
            $author_number = $this->config->author_number;
        }

        // Title
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}

        // Content
        if(!empty($this->config->body)){$this->content->body = $this->config->body;} else {$this->content->body = '';}

        $text = '';
        $text .= '
        <!-- Start Instructor Post Area -->
		<div class="instructor-area ptb-100">
			<div class="container">
				<div class="section-title">
                    <h2>'. $this->content->title .'</h2>
					<p>'. $this->content->body .'</p>
				</div>

				<div class="row justify-content-center">';
                    for($i = 1; $i <= $author_number; $i++) {
                        $img                   = 'img' . $i;
                        $author_title         = 'author_title' . $i;
                        $author_content       = 'author_content' . $i;
                        $author_button_link   = 'author_button_link' . $i;

                        // Image
                        if(isset($this->config->$img)) { $img = $this->config->$img; }else{ $img = ''; }

                        // Title
                        if(isset($this->config->$author_title)) { $author_title = $this->config->$author_title; }else{ $author_title = ''; }

                        // Content
                        if(isset($this->config->$author_content)) { $author_content = $this->config->$author_content; }else{ $author_content = ''; }

                        // Button Link
                        if(isset($this->config->$author_button_link)) { $author_button_link = $this->config->$author_button_link; }else{ $author_button_link = ''; }
                        $text .= '
                        <div class="col-lg-3 col-sm-6">
                            <div class="single-instructor">';
                                if($img):
                                    $img = $img;
                                    $text .= '                    
                                    <a href="'.$author_button_link.'">
                                        <img src="'.edma_block_image_process($img).'" alt="'.$author_title.'">
                                    </a>';
                                endif;
                                $text .= '
                                
                                
                                <ul class="instructor-info d-flex justify-content-between align-items-center">
                                    <li>
                                        <h3>
                                            <a href="'.$author_button_link.'">'.$author_title.'</a>
                                        </h3>
                                        <span>'.$author_content.'</span>
                                    </li>
                                    <li>
                                        <a href="'.$author_button_link.'" class="read-btn">
                                            <i class="ri-arrow-right-s-line"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>';
                    } $text .= '
				</div>
			</div>
		</div>
		<!-- End Instructor-post Area -->';
        
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