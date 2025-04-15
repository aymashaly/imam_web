<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edma/inc/course_handler/edma_course_handler.php');

class block_edma_course_desc extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edma_course_desc');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edma/inc/block_handler/specialization.php');
    }

    public function get_content() {
        global $CFG, $DB, $COURSE, $USER, $PAGE;

        $this->content         =  new stdClass;        

        $edmaCourseHandler = new edmaCourseHandler();
        $edmaCourse = $edmaCourseHandler->edmaGetCourseDetails($COURSE->id);
        $edmaCourseDescription = $edmaCourseHandler->edmaGetCourseDescription($COURSE->id, 99999999999999999999999);

        $text = '';

        $text .= '
        <div class="courses-overview">
            '.$edmaCourseDescription.'
        </div>';
        
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