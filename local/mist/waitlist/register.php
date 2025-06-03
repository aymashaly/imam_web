<?php
require('../../../config.php');
require_login();

$courseid = required_param('courseid', PARAM_INT);
$userid = $USER->id;

$exists = $DB->record_exists('local_mist_waitlist', ['userid' => $userid, 'courseid' => $courseid]);

if (!$exists) {
    $record = (object)[
        'userid' => $userid,
        'courseid' => $courseid,
        'timecreated' => time(),
    ];
    $DB->insert_record('local_mist_waitlist', $record);
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]), 'تم تسجيل رغبتك، وسيتم إعلامك عند فتح برنامج مشابه.');
}else{
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]), 'تم التقديم مسبقاً بالفعل');
}

