<?php
/*
@edmaRef: @
*/

defined('MOODLE_INTERNAL') || die();
include_once($CFG->dirroot . '/course/lib.php');

class edmaPageHandler {
  public function edmaGetPageTitle() {
    global $PAGE, $COURSE, $DB, $CFG;

    $edmaReturn = $PAGE->heading;

    if(
      $DB->record_exists('course', array('id' => $COURSE->id))
      && $COURSE->format == 'site'
      && $PAGE->cm
      && $PAGE->cm->name !== NULL
    ){
      $edmaReturn = $PAGE->cm->name;
    } elseif($PAGE->pagetype == 'blog-index') {
      $edmaReturn = get_string("blog", "blog");
    }

    return $edmaReturn;
  }
}
