<?php

defined('MOODLE_INTERNAL') || die();

class local_mist_observer {

    public static function course_updated(\core\event\course_updated $event) {
        global $DB;

        $courseid = $event->objectid;
        $users = $DB->get_records('local_mist_waitlist', ['courseid' => $courseid]);

        foreach ($users as $user) {
            $userobj = $DB->get_record('user', ['id' => $user->userid]);

            $message = new \core\message\message();
            $message->component = 'local_mist';
            $message->name = 'waitlist_notification';
            $message->userfrom = \core_user::get_noreply_user();
            $message->userto = $userobj;
            $message->subject = "تم فتح التسجيل في البرنامج التدريبي";
            $message->fullmessage = "تم فتح التسجيل في البرنامج التدريبي الذي طلبت الانضمام إليه.";
            $message->fullmessageformat = FORMAT_PLAIN;
            $message->fullmessagehtml = "<p>تم فتح التسجيل في البرنامج التدريبي الذي طلبت الانضمام إليه.</p>";
            $message->smallmessage = "تم فتح التسجيل!";
            $message->notification = 1;

            message_send($message);
        }

        // حذف المستخدمين من قائمة الانتظار (اختياري)
        $DB->delete_records('local_mist_waitlist', ['courseid' => $courseid]);
    }
}
