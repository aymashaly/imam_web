<?php
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot . '/theme/edma/inc/course_handler/edma_course_handler.php');
require_once($CFG->dirroot . '/theme/edma/inc/block_handler/get-content.php');
global $CFG;
class block_edma_course_filter extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_course_filter');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
        if (empty($this->config)) {
            $this->config = new \stdClass();
            $this->config->style = 1;
            $this->config->title = 'Expand Your Career Opportunity With Our Courses';
            $this->config->top_title = 'Popular Courses';
            $this->config->total_student_title = 'Total Student: ';
            $this->config->last_updated_title = 'Last Updated: ';
            $this->config->enroll_text = 'Enroll Now';
        }
    }

    public function get_content() {
        global $CFG, $DB, $COURSE, $USER, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->top_title)){$this->content->top_title = $this->config->top_title;} else {$this->content->top_title = '';} 
        if(!empty($this->config->total_student_title)){$this->content->total_student_title = $this->config->total_student_title;} else {$this->content->total_student_title = '';} 
        if(!empty($this->config->last_updated_title)){$this->content->last_updated_title = $this->config->last_updated_title;} else {$this->content->last_updated_title = '';} 
        if(!empty($this->config->enroll_text)){$this->content->enroll_text = $this->config->enroll_text;} else {$this->content->enroll_text = '';} 
        if(!empty($this->config->courses)){
            $coursesArr = $this->config->courses;
            $courses = new stdClass();
            foreach ($coursesArr as $key => $course) {
                $courseObj = new stdClass();
                $courseObj->id = $course;
                $courseRecord = $DB->get_record('course', array('id' => $courseObj->id), 'category');
                $courseCategory = $DB->get_record('course_categories',array('id' => $courseRecord->category));
                $courseCategory = core_course_category::get($courseCategory->id);
                $courseObj->category = $courseCategory->id;
                $courseObj->category_name = $courseCategory->get_formatted_name();
                $courses->$course = $courseObj;
            }
        }
        $text = '';
        $text .= '
        <!-- Start Courses Area -->
        <div class="courses-area pt-100 pb-70">
            <div class="container">
                <div class="section-title wow animate__animated animate__fadeInUp delay-0-2s">
                    <span class="top-title">'.$this->content->top_title.'</span>
                    <h2>'.$this->content->title.'</h2>
                </div>

                <div class="row justify-content-center">';
                    if(!empty($this->config->courses)){
                        $chelper = new coursecat_helper();
                        $total_courses = count($coursesArr);
                        foreach ($courses as $course) {
                            if ($DB->record_exists('course', array('id' => $course->id))) {
                                $edmaCourseHandler = new edmaCourseHandler();
                                $edmaCourse = $edmaCourseHandler->edmaGetCourseDetails($course->id);

                                $wordsArray = explode(' ', strip_tags($edmaCourseHandler->edmaGetCourseDescription($course->id, 99999999999999)));
                                $first20Words = array_slice($wordsArray, 0, 20);
                                $edmaCourseDescription = implode(' ', $first20Words);                            
                                $text .= '
                                <div class="custom-col wow animate__animated animate__fadeInUp delay-0-2s">
                                    <div class="single-courses">
                                        <a href="'. $edmaCourse->url .'" class="courses-main-img">
                                            '.$edmaCourse->edmaRender->coverImage.'
                                        </a>

                                        <div class="courses-content">
                                            <h3>
                                                <a href="'. $edmaCourse->url .'">'.$edmaCourse->fullName.'</a>
                                            </h3>
                                            <ul class="admin">
                                                <li>
                                                    <a href="'. $edmaCourse->url .'">
                                                        <i class="bx bx-user"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <span>'.$this->content->total_student_title.' </span>
                                                </li>
                                                <li>
                                                    <a href="'. $edmaCourse->url .'">
                                                        '.$edmaCourse->enrolments.'
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="rating">
                                                <li>
                                                    <i class="flaticon-clock"></i> '.$this->content->last_updated_title.' '. $edmaCourse->edmaRender->updatedDate .'
                                                </li>
                                            </ul>';
                                            if($edmaCourse->course_price) {
                                                $text .= '
                                                <h4>'.get_config('theme_edma', 'site_currency') .''.$edmaCourse->course_price.'</h4>';
                                            }else{
                                                $text .= '
                                                <h4>'.get_string('course_free', 'theme_edma').'</h4>';
                                            } $text .= '
                                        </div>

                                        <div class="courses-hover-content">
                                            <div class="sk">
                                                <div>
                                                    <h3>
                                                        <a href="'. $edmaCourse->url .'">'.$edmaCourse->fullName.'</a>
                                                    </h3>
                                                    
                                                    <p>'.$edmaCourseDescription.' </p>

                                                    ';
                                                    if($this->content->enroll_text):
                                                        $text .='
                                                        <div class="courses-btn d-flex justify-content-between align-items-center">
                                                            <a href="'. $edmaCourse->url .'" class="default-btn">
                                                                '.$this->content->enroll_text.'
                                                            </a>
                                                            <a href="'. $edmaCourse->url .'" class="default-btn wish">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </div>';
                                                    endif;
                                                    $text .='
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                    }
                    $text .= '
                </div> 
            </div>
        </div>
        <!-- End Courses Area -->';

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