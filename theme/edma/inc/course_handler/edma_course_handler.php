<?php
/*
* COURSE HANDLER
*/

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot. '/course/renderer.php');
include_once($CFG->dirroot . '/course/lib.php');

class edmaCourseHandler {
    public function edmaGetCourseDetails($courseId) {
        global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;


        $courseId = (int)$courseId;
        if ($DB->record_exists('course', array('id' => $courseId))) {
        // @edmaComm: Initiate
        $edmaCourse = new \stdClass();
        $chelper = new coursecat_helper();
        $courseContext = context_course::instance($courseId);

        $courseRecord = $DB->get_record('course', array('id' => $courseId));
        $courseElement = new core_course_list_element($courseRecord);

        /* @edmaBreak */
        $courseId = $courseRecord->id;
        $courseShortName = $courseRecord->shortname;
        $courseFullName = $courseRecord->fullname;
        $courseSummary = $chelper->get_course_formatted_summary($courseElement, array('noclean' => true, 'para' => false));
        $courseFormat = $courseRecord->format;
        $courseAnnouncements = $courseRecord->newsitems;
        $courseStartDate = $courseRecord->startdate;
        $courseEndDate = $courseRecord->enddate;
        $courseVisible = $courseRecord->visible;
        $courseCreated = $courseRecord->timecreated;
        $courseUpdated = $courseRecord->timemodified;
        $courseRequested = $courseRecord->requested;
        $courseEnrolmentCount = count_enrolled_users($courseContext);
        $course_is_enrolled = is_enrolled($courseContext, $USER->id, '', true);

        /* @edmaBreak */
        $categoryId = $courseRecord->category;

        try {
            $courseCategory = core_course_category::get($categoryId);
            $categoryName = $courseCategory->get_formatted_name();
            $categoryUrl = $CFG->wwwroot . '/course/index.php?categoryid='.$categoryId;
        } catch (Exception $e) {
            $courseCategory = "";
            $categoryName = "";
            $categoryUrl = "";
        }

        /* @edmaBreak */
        $enrolmentLink = $CFG->wwwroot . '/enrol/index.php?id=' . $courseId;
        $courseUrl = new moodle_url('/course/view.php', array('id' => $courseId));
        // @edmaComm: Start Payment
        $enrolInstances = enrol_get_instances($courseId, true);

        $course_price = '';
        $course_currency = '';
        foreach($enrolInstances as $singleenrolInstances){
            if($singleenrolInstances->enrol == 'paypal'){
                $course_price = $singleenrolInstances->cost;
                $course_currency = $singleenrolInstances->currency;
            }elseif($singleenrolInstances->enrol == 'stripe'){
                $course_price = $singleenrolInstances->cost;
                $course_currency = $singleenrolInstances->currency;
            }elseif($singleenrolInstances->enrol == 'payfast'){
                $course_price = $singleenrolInstances->cost;
                $course_currency = $singleenrolInstances->currency;
            }else{
                $course_price =  $singleenrolInstances->cost;
                $course_currency = $singleenrolInstances->currency;
            }
        }
        $edmaArrayOfCosts = array();
            $edmaCourseContacts = array();
            if ($courseElement->has_course_contacts()) {
                foreach ($courseElement->get_course_contacts() as $key => $courseContact) {
                $edmaCourseContacts[$key] = new \stdClass();
                $edmaCourseContacts[$key]->userId = $courseContact['user']->id;
                $edmaCourseContacts[$key]->username = $courseContact['user']->username;
                $edmaCourseContacts[$key]->name = $courseContact['user']->firstname . ' ' . $courseContact['user']->lastname;
                $edmaCourseContacts[$key]->role = $courseContact['role']->displayname;
                $edmaCourseContacts[$key]->profileUrl = new moodle_url('/user/view.php', array('id' => $courseContact['user']->id, 'course' => SITEID));
                }
            }


        // @edmaComm: Process first image
        $contentimages = $contentfiles = $CFG->wwwroot . '/theme/edma/images/edmaBg.png';
        foreach ($courseElement->get_course_overviewfiles() as $file) {
            $isimage = $file->is_valid_image();
            $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php",
                    '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                    $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
            if ($isimage) {
                $contentimages = $url;
            } else {
                $contentfiles = $CFG->wwwroot . '/theme/edma/images/edmaBg.png';
            }
        }

        /* Map data */
        $edmaCourse->courseId = $courseId;
        $edmaCourse->enrolments = $courseEnrolmentCount;
        $edmaCourse->categoryId = $categoryId;
        $edmaCourse->categoryName = $categoryName;
        $edmaCourse->categoryUrl = $categoryUrl;
        $edmaCourse->shortName = $courseShortName;
        $edmaCourse->fullName = format_text($courseFullName, FORMAT_HTML, array('filter' => true));
        $edmaCourse->summary = $courseSummary;
        $edmaCourse->imageUrl = $contentimages;
        $edmaCourse->format = $courseFormat;
        $edmaCourse->announcements = $courseAnnouncements;
        $edmaCourse->startDate = userdate($courseStartDate, get_string('strftimedatefullshort', 'langconfig'));
        $edmaCourse->endDate = userdate($courseEndDate, get_string('strftimedatefullshort', 'langconfig'));
        $edmaCourse->visible = $courseVisible;
        $edmaCourse->created = userdate($courseCreated, get_string('strftimedatefullshort', 'langconfig'));
        $edmaCourse->updated = userdate($courseUpdated, get_string('strftimedatefullshort', 'langconfig'));
        $edmaCourse->requested = $courseRequested;
        $edmaCourse->enrolmentLink = $enrolmentLink;
        $edmaCourse->url = $courseUrl;
        $edmaCourse->teachers = $edmaCourseContacts;
        $edmaCourse->course_price = $course_price;
        $edmaCourse->course_currency = $course_currency;
        $edmaCourse->course_is_enrolled = $course_is_enrolled;

        /* Render object */
        $edmaRender = new \stdClass();
        $edmaRender->enrolmentIcon = '';
        $edmaRender->enrolmentIcon1 = '';
        $edmaRender->announcementsIcon     =     '';
        $edmaRender->announcementsIcon1     =     '';
        $edmaRender->updatedDate           =     '';
        $edmaRender->updatedDate         =     userdate($courseUpdated, get_string('strftimedatefullshort', 'langconfig'));
        $edmaRender->title             =     '<h3><a href="'. $edmaCourse->url .'">'. $edmaCourse->fullName .'</a></h3>';
        $edmaRender->coverImage        =     '<img class="img-whp" src="'. $contentimages .'" alt="'.$edmaCourse->fullName.'">';
        $edmaRender->ImageUrl = $contentimages;
        /* @edmaBreak */
        $edmaCourse->edmaRender = $edmaRender;
        return $edmaCourse;
        }
        return null;
    }

    public function edmaGetCourseDescription($courseId, $maxLength){
        global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;
    
        if ($DB->record_exists('course', array('id' => $courseId))) {
        $chelper = new coursecat_helper();
        $courseContext = context_course::instance($courseId);
    
        $courseRecord = $DB->get_record('course', array('id' => $courseId));
        $courseElement = new core_course_list_element($courseRecord);
    
        if ($courseElement->has_summary()) {
            $courseSummary = $chelper->get_course_formatted_summary($courseElement, array('noclean' => false, 'para' => false));
            if($maxLength != null) {
            if (strlen($courseSummary) > $maxLength) {
                $courseSummary = wordwrap($courseSummary, $maxLength);
                $courseSummary = substr($courseSummary, 0, strpos($courseSummary, "\n")) . '...';
            }
            }
            return $courseSummary;
        }
    
        }
        return null;
    }

    public function edmaListCategories(){
        global $DB, $CFG;
        $topcategory = core_course_category::top();
        $topcategorykids = $topcategory->get_children();
        $areanames = array();
        foreach ($topcategorykids as $areaid => $topcategorykids) {
            $areanames[$areaid] = $topcategorykids->get_formatted_name();
            foreach($topcategorykids->get_children() as $k=>$child){
                $areanames[$k] = $child->get_formatted_name();
            }
        }
        return $areanames;
    }

    public function edmaGetCategoryDetails($categoryId){
        global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;
    
        if ($DB->record_exists('course_categories', array('id' => $categoryId))) {
    
        $categoryRecord = $DB->get_record('course_categories', array('id' => $categoryId));
    
        $chelper = new coursecat_helper();
        $categoryObject = core_course_category::get($categoryId);
    
        $edmaCategory = new \stdClass();
    
        $categoryId = $categoryRecord->id;
        $categoryName = format_text($categoryRecord->name, FORMAT_HTML, array('filter' => true));
        $categoryDescription = $chelper->get_category_formatted_description($categoryObject);
    
        $categorySummary = format_string($categoryRecord->description, $striplinks = true,$options = null);
        $isVisible = $categoryRecord->visible;
        $categoryUrl = $CFG->wwwroot . '/course/index.php?categoryid=' . $categoryId;
        $categoryCourses = $categoryObject->get_courses();
        $categoryCoursesCount = count($categoryCourses);
    
        $categoryGetSubcategories = [];
        $categorySubcategories = [];
        if (!$chelper->get_categories_display_option('nodisplay')) {
            $categoryGetSubcategories = $categoryObject->get_children($chelper->get_categories_display_options());
        }
        foreach($categoryGetSubcategories as $k=>$edmaSubcategory) {
            $edmaSubcat = new \stdClass();
            $edmaSubcat->id = $edmaSubcategory->id;
            $edmaSubcat->name = $edmaSubcategory->name;
            $edmaSubcat->description = $edmaSubcategory->description;
            $edmaSubcat->depth = $edmaSubcategory->depth;
            $edmaSubcat->coursecount = $edmaSubcategory->coursecount;
            $categorySubcategories[$edmaSubcategory->id] = $edmaSubcat;
        }
    
        $categorySubcategoriesCount = count($categorySubcategories);
    
        /* Do image */
        $outputimage = '';
        //edmaComm: Fetching the image manually added to the coursecat description via the editor.
        $description = $chelper->get_category_formatted_description($categoryObject);
        $src = "";
        if ($description) {
            $dom = new DOMDocument();
            $dom->loadHTML($description);
            $xpath = new DOMXPath($dom);
            $src = $xpath->evaluate("string(//img/@src)");
        }
        if ($src && $description){
            $outputimage = $src;
        } else {
            foreach($categoryCourses as $child_course) {
            if ($child_course === reset($categoryCourses)) {
                foreach ($child_course->get_course_overviewfiles() as $file) {
                    if ($file->is_valid_image()) {
                        $imagepath = '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename();
                        $imageurl = file_encode_url($CFG->wwwroot . '/pluginfile.php', $imagepath, false);
                        $outputimage  =  $imageurl;
                        // Use the first image found.
                        break;
                    }
                }
            }
            }
        }
    
        /* Map data */
        $edmaCategory->categoryId = $categoryId;
        $edmaCategory->categoryName = $categoryName;
        $edmaCategory->categoryDescription = $categoryDescription;
        $edmaCategory->categorySummary = $categorySummary;
        $edmaCategory->isVisible = $isVisible;
        $edmaCategory->categoryUrl = $categoryUrl;
        $edmaCategory->coverImage = $outputimage;
        $edmaCategory->ImageUrl = $outputimage;
        $edmaCategory->courses = $categoryCourses;
        $edmaCategory->coursesCount = $categoryCoursesCount;
        $edmaCategory->subcategories = $categorySubcategories;
        $edmaCategory->subcategoriesCount = $categorySubcategoriesCount;
        return $edmaCategory;
    
        }
    }

    public function edmaGetExampleCategories($maxNum) {
        global $CFG, $DB;
    
        $edmaCategories = $DB->get_records('course_categories', array(), $sort='', $fields='*', $limitfrom=0, $limitnum=$maxNum);
    
        $edmaReturn = array();
        foreach ($edmaCategories as $edmaCategory) {
        $edmaReturn[] = $this->edmaGetCategoryDetails($edmaCategory->id);
        }
        return $edmaReturn;
    }

    public function edmaGetExampleCategoriesIds($maxNum) {
        global $CFG, $DB;
    
        $edmaCategories = $this->edmaGetExampleCategories($maxNum);
    
        $edmaReturn = array();
        foreach ($edmaCategories as $key => $edmaCategory) {
        $edmaReturn[] = $edmaCategory->categoryId;
        }
        return $edmaReturn;
    }
}
