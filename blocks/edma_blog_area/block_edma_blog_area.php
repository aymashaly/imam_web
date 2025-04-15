<?php
global $CFG;
require_once($CFG->dirroot .'/blog/lib.php');
require_once($CFG->dirroot .'/blog/locallib.php');
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_blog_area extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_blog_area');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->top_title        = 'Top Articles';
            $this->config->title            = 'Want To Learn More? Read Blog';
            $this->config->by_title         = 'By';
            $this->config->read_more_text   = 'Read Blog';
        }
    }

    public function get_content() {
        global $CFG, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        
        if(!empty($this->config->top_title)){$this->content->top_title = $this->config->top_title;} else {$this->content->top_title = '';}

        if(!empty($this->config->by_title)){$this->content->by_title = $this->config->by_title;} else {$this->content->by_title = '';}
        
        if(!empty($this->config->read_more_text)){$this->content->read_more_text = $this->config->read_more_text;} else {$this->content->read_more_text = '';}

        if(!empty($this->config->posts)){$this->content->posts = $this->config->posts;} else { $this->content->posts = '';}

        $url = new moodle_url('/blog/index.php');

        global $CFG;
        $bloglisting = new blog_listing();

        $entries = $bloglisting->get_entries();
        
        $entrieslist = array();
        $viewblogurl = new moodle_url('/blog/index.php');

        $text = '';
        $text .= '
        <!-- Start Blog Area -->
		<div class="blog-area pb-70">
			<div class="container">
				<div class="section-title wow animate__animated animate__fadeInUp delay-0-2s">
					<span class="top-title">'.$this->content->top_title.'</span>
					<h2>'.$this->content->title.'</h2>
				</div>

				<div class="row justify-content-center">';
                    if($this->content->posts):
                        foreach ($entries as $entryid => $entry) {
                            $viewblogurl->param('entryid', $entryid);
                            $entrylink = html_writer::link($viewblogurl, shorten_text($entry->subject));
                            $entrieslist[] = $entrylink;
            
                            $blogentry = new blog_entry($entryid);
                            $blogattachments = $blogentry->get_attachments();

                            $short_summary = $entry->summary;
                            $short_summary = strip_tags( $short_summary);
                            $short_summary = implode(' ', array_slice(str_word_count($short_summary,1), 0, 15));

                            if(in_array($entry->id, $this->content->posts)):
                                $text .= '
                                <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeInUp delay-0-2s">
                                    <div class="single-blog">
                                        <div class="blog-img">
                                            <a href="'.$viewblogurl.'">
                                                <img src="'.$blogattachments[0]->url.'" alt="'.$entry->subject.'">
                                            </a>
                                            <span class="date">'. userdate($entry->created, '%d %b', 0) .'</span>
                                        </div>

                                        <div class="blog-content">
                                            <h3>
                                                <a href="'.$viewblogurl.'">'.$entry->subject.'</a>
                                            </h3>

                                            <ul class="d-flex justify-content-between">
                                                <li class="admin">
                                                    <a href="'.$viewblogurl.'"><i class="bx bx-user"></i></a>
                                                    <span>'.$this->content->by_title.'</span>
                                                    <a href="'.$viewblogurl.'">'.$entry->firstname.' '.$entry->lastname.'</a>
                                                </li>
                                                <li>
                                                    <a href="'.$viewblogurl.'" class="read-more">
                                                        '.$this->content->read_more_text.'
                                                        <i class="ri-arrow-right-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>';
                            endif;
                        }
                    endif;
                    $text .= '
				</div>
			</div>
		</div>
		<!-- End Blog Area -->'; 
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