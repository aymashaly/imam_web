<?php
global $CFG;
require_once($CFG->dirroot . '/theme/edma/inc/course_handler/edma_course_handler.php');
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
class block_edma_categories extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_categories');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $edmaCourseHandler = new edmaCourseHandler();
            $edmaCategories = $edmaCourseHandler->edmaGetExampleCategoriesIds(8);
            $this->config = new \stdClass();
            $this->config->style = 1;
            $this->config->title = 'Browse Top Categories';
            $this->config->top_title = 'Top Categories';
            $this->config->button_text = '124+ Categories ';
            $this->config->bottom_title = 'Browse All Different';
            $this->config->button_link = $CFG->wwwroot . '/course';
            $this->config->icon1 = 'flaticon-fine-arts';
            $this->config->icon2 = 'flaticon-developer';
            $this->config->icon3 = 'flaticon-portfolio';
            $this->config->icon4 = 'flaticon-profits';
            $this->config->icon5 = 'flaticon-job';
            $this->config->icon6 = 'flaticon-growth';
            $this->config->icon7 = 'flaticon-promotion';
            $this->config->icon8 = 'flaticon-skill';
            $this->config->icon9 = 'flaticon-target';
            $this->config->icon10 = 'flaticon-certificate';
            $this->config->icon11 = 'flaticon-growth';
            $this->config->icon12 = 'flaticon-puzzle';
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

        if(!empty($this->config->top_title)){$this->content->top_title = $this->config->top_title;} else {$this->content->top_title = '';}

        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;} else {$this->content->button_text = '';}

        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;} else {$this->content->button_link = '';}

        if(!empty($this->config->bottom_title)){$this->content->bottom_title = $this->config->bottom_title;} else {$this->content->bottom_title = '';}

        $text = '';
        $text .= '
        <!-- Start Categories Area -->
		<div class="categories-area ptb-100">
			<div class="container">
				<div class="section-title">
					<span class="top-title">'.$this->content->top_title.'</span>
					<h2>'.$this->content->title.'</h2>
				</div>

				<div class="row">';
                    $topcategory = core_course_category::top();
                    $col_class = "";
                    if ($data->items == 1) {
                        $col_class = "col-sm-12 col-lg-12";
                    } else if ($data->items == 2) {
                        $col_class = "col-sm-6 col-lg-6";
                    } else if ($data->items == 3) {
                        $col_class = "col-sm-6 col-lg-4";
                    } else {
                        $col_class = "col-lg-3 col-sm-6";
                    }
                    
                    if ($data->items > 0) {
                        for ($i = 1; $i <= $data->items; $i++) {
                            $icon = 'icon' . $i;
                            $categoryID = 'category' . $i;
                            $category = $DB->get_record('course_categories',array('id' => $data->$categoryID));
                            if ($DB->record_exists('course_categories', array('id' => $data->$categoryID))) {
                                $chelper = new coursecat_helper();
                                $categoryID = $category->id;
                                $category = core_course_category::get($categoryID);
                                $categoryname = $category->get_formatted_name();
                                $children_courses = $category->get_courses();
                                if($children_courses >= 1){
                                    $countNoOfCourses = '<p>'.count($children_courses).'</p>';
                                } else {
                                    $countNoOfCourses = '';
                                }
                                $text .= '
                                <div class="'.$col_class.' wow animate__animated animate__fadeInUp delay-0-2s">
                                    <a href="'.$CFG->wwwroot .'/course/index.php?categoryid='.$categoryID.'" class="single-categorie d-flex justify-content-between align-items-center align-items-center">
                                        <h3>'.$categoryname.'</h3>
                                        <i class="'.$data->$icon.'"></i>
                                    </a>
                                </div>';
                            }
                        }
                    }
                    if(!empty($this->content->button_text) && !empty($this->content->button_link)){
                        $text .= '
                        <div class="col-lg-12 wow animate__animated animate__fadeInUp delay-0-8s">
                            <p class="text-center all-browse">'.$this->content->bottom_title.' <a href="'.$this->content->button_link.'" class="read-more">'.$this->content->button_text.' <i class="ri-arrow-right-line"></i></a></p>
                        </div>';
                    }
                    $text .= '
				</div>
			</div>
		</div>
		<!-- End Categories Area -->';

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