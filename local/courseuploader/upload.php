<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_login();
require_capability('moodle/site:config', context_system::instance());

require_once($CFG->dirroot.'/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

$excelFile = $_FILES['excelfile']['tmp_name'];
$spreadsheet = IOFactory::load($excelFile);
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

foreach ($rows as $index => $row) {
    if ($index === 0) continue; 
    [$name, $categoryname, $start, $end, $email] = $row;

    $category = $DB->get_record('course_categories', ['name' => $categoryname]);
    if (!$category) {
        $category = new stdClass();
        $category->name = $categoryname;
        $category->id = $DB->insert_record('course_categories', $category);
    }

    $newcourse = new stdClass();
    $newcourse->fullname = $name;
    $newcourse->shortname = $name . '_' . rand(100,999);
    $newcourse->category = $category->id;
    $newcourse->startdate = strtotime($start);
    $newcourse->enddate = strtotime($end);
    $newcourse->visible = 1;

    $course = create_course($newcourse);

    $trainer = $DB->get_record('user', ['email' => $email]);
    if ($trainer) {
        $context = context_course::instance($course->id);
        role_assign(3, $trainer->id, $context->id); // 3 = مدرب
    }
}

redirect(new moodle_url('/local/courseuploader/index.php'), get_string('courses_created','local_courseuploader'), 5);
