<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    enrol_apply
 * @copyright  emeneo.com (http://emeneo.com/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     emeneo.com (http://emeneo.com/)
 * @author     Johannes Burk <johannes.burk@sudile.com>
 */

// الاسم المعروض في قوائم الإدارة
$string['enrolname'] = 'تأكيد تسجيل المقرر';
$string['pluginname'] = 'تأكيد تسجيل المقرر';
$string['pluginname_desc'] = 'باستخدام هذه الإضافة، يمكن للمستخدمين التقدم بطلب للتسجيل في مقرر. بعد ذلك، يجب على المعلم أو مدير الموقع الموافقة على الطلب قبل أن يتم تسجيل المستخدم.';

// تأكيد البريد الإلكتروني
$string['confirmmail_heading'] = 'بريد التأكيد';
$string['confirmmail_desc'] = '';
$string['confirmmailsubject'] = 'موضوع بريد التأكيد';
$string['confirmmailsubject_desc'] = '';
$string['confirmmailcontent'] = 'محتوى بريد التأكيد';
$string['confirmmailcontent_desc'] = 'يرجى استخدام العلامات الخاصة التالية لاستبدال محتوى البريد ببيانات من مودل.<br/>{firstname}: الاسم الأول للمستخدم؛ {content}: اسم المقرر؛ {lastname}: اسم العائلة للمستخدم؛ {username}: اسم المستخدم المسجل؛ {timeend}: تاريخ انتهاء التسجيل';

// بريد قائمة الانتظار
$string['waitmail_heading'] = 'بريد قائمة الانتظار';
$string['waitmail_desc'] = '';
$string['waitmailsubject'] = 'موضوع بريد قائمة الانتظار';
$string['waitmailsubject_desc'] = '';
$string['waitmailcontent'] = 'محتوى بريد قائمة الانتظار';
$string['waitmailcontent_desc'] = 'يرجى استخدام العلامات الخاصة التالية لاستبدال محتوى البريد ببيانات من مودل.<br/>{firstname}: الاسم الأول للمستخدم؛ {content}: اسم المقرر؛ {lastname}: اسم العائلة للمستخدم؛ {username}: اسم المستخدم المسجل';

// بريد الإلغاء
$string['cancelmail_heading'] = 'بريد الإلغاء';
$string['cancelmail_desc'] = '';
$string['cancelmailsubject'] = 'موضوع بريد الإلغاء';
$string['cancelmailsubject_desc'] = '';
$string['cancelmailcontent'] = 'محتوى بريد الإلغاء';
$string['cancelmailcontent_desc'] = 'يرجى استخدام العلامات الخاصة التالية لاستبدال محتوى البريد ببيانات من مودل.<br/>{firstname}: الاسم الأول للمستخدم؛ {content}: اسم المقرر؛ {lastname}: اسم العائلة للمستخدم؛ {username}: اسم المستخدم المسجل';

// إعدادات الإشعارات
$string['notify_heading'] = 'إعدادات الإشعارات';
$string['notify_desc'] = 'تحديد من يتم إشعاره بطلبات التسجيل الجديدة.';
$string['notifycoursebased'] = "إشعار طلب تسجيل جديد (حسب المقرر، مثلاً معلمو المقرر)";
$string['notifycoursebased_desc'] = "الإعداد الافتراضي: إشعار كل من لديه صلاحية 'إدارة تسجيل الطلب' للمقرر المعني (مثل المعلمين والمديرين)";
$string['notifyglobal'] = "إشعار طلب تسجيل جديد (عام، مثلاً المديرون العامون والمشرفون)";
$string['notifyglobal_desc'] = "تحديد من يتم إشعاره بطلبات التسجيل الجديدة لأي مقرر.";

// أنواع الرسائل
$string['messageprovider:application'] = 'إشعارات طلبات تسجيل المقرر';
$string['messageprovider:confirmation'] = 'إشعارات تأكيد طلبات تسجيل المقرر';
$string['messageprovider:cancelation'] = 'إشعارات إلغاء طلبات تسجيل المقرر';
$string['messageprovider:waitinglist'] = 'إشعارات تأجيل طلبات تسجيل المقرر';

// نصوص الإشعارات
$string['newapplicationnotification'] = 'يوجد طلب تسجيل جديد في المقرر بانتظار المراجعة.';
$string['applicationconfirmednotification'] = 'تم تأكيد طلب تسجيلك في المقرر.';
$string['applicationcancelednotification'] = 'تم إلغاء طلب تسجيلك في المقرر.';
$string['applicationdeferrednotification'] = 'تم تأجيل طلب تسجيلك في المقرر (أنت الآن في قائمة الانتظار).';

// واجهة تأكيد المستخدمين
$string['confirmusers'] = 'تأكيد التسجيل';
$string['confirmusers_desc'] = 'المستخدمون في الصفوف ذات اللون الرمادي موجودون في قائمة الانتظار.';

// أعمدة الجدول
$string['coursename'] = 'المقرر';
$string['applyuser'] = 'الاسم / اسم العائلة';
$string['applyusermail'] = 'البريد الإلكتروني';
$string['applydate'] = 'تاريخ التسجيل';
$string['btnconfirm'] = 'تأكيد الطلبات';
$string['btnwait'] = 'تأجيل الطلبات';
$string['btncancel'] = 'إلغاء الطلبات';
$string['enrolusers'] = 'تسجيل المستخدمين';

// صلاحيات التسجيل
$string['status'] = 'السماح بتأكيد تسجيل المقرر';
$string['newenrols'] = 'السماح بطلبات تسجيل مقرر جديدة';
$string['confirmenrol'] = 'إدارة الطلب';

// الصلاحيات
$string['apply:config'] = 'تهيئة حالات تسجيل الطلب';
$string['apply:manage'] = 'إدارة تسجيلات المستخدمين';
$string['apply:manageapplications'] = 'إدارة تسجيل الطلب';
$string['apply:unenrol'] = 'إلغاء مستخدمين من المقرر';
$string['apply:unenrolself'] = 'إلغاء الذات من المقرر';

// رسالة للمستخدم
$string['notification'] = '<b>تم إرسال طلب التسجيل بنجاح</b>. <br/><br/>سيتم إعلامك عبر البريد الإلكتروني عند تأكيد تسجيلك.';

// إعدادات إضافية
$string['mailtoteacher_suject'] = 'طلب تسجيل جديد!';
$string['editdescription'] = 'وصف منطقة النص';
$string['comment'] = 'تعليق';
$string['applycomment'] = 'تعليق';
$string['applymanage'] = 'إدارة طلبات التسجيل';

$string['status_desc'] = 'السماح بدخول المستخدمين المسجلين داخلياً.';
$string['user_profile'] = 'ملف المستخدم';

$string['show_standard_user_profile'] = 'عرض حقول ملف المستخدم القياسية في شاشة التسجيل';
$string['show_extra_user_profile'] = 'عرض حقول ملف المستخدم الإضافية في شاشة التسجيل';

$string['custom_label'] = 'تسمية مخصصة';

// إعدادات الحد الأقصى للمسجلين
$string['maxenrolled'] = 'الحد الأقصى للمستخدمين المسجلين';
$string['maxenrolled_help'] = 'يحدد الحد الأقصى لعدد المستخدمين الذين يمكنهم التسجيل ذاتياً. 0 تعني لا يوجد حد.';
$string['maxenrolledreached_left'] = 'تم الوصول إلى الحد الأقصى المسموح به للمستخدمين';
$string['maxenrolledreached_right'] = '';

$string['cantenrol'] = 'التسجيل معطل أو غير نشط';

$string['maxenrolled_tip_1'] = 'من أصل';
$string['maxenrolled_tip_2'] = 'مقعد محجوز مسبقاً.';

// إعدادات انتهاء الصلاحية
$string['defaultperiod'] = 'مدة التسجيل الافتراضية';
$string['defaultperiod_desc'] = 'المدة الافتراضية التي يكون فيها التسجيل فعالاً. إذا تم تعيينها إلى صفر، ستكون مدة التسجيل غير محدودة افتراضياً.';
$string['defaultperiod_help'] = 'المدة الافتراضية التي يكون فيها التسجيل فعالاً، بدءاً من لحظة تسجيل المستخدم. إذا تم تعطيلها، ستكون مدة التسجيل غير محدودة افتراضياً.';
$string['expiry_heading'] = 'إعدادات انتهاء الصلاحية';
$string['expiry_desc'] = '';
$string['expiredaction'] = 'إجراء انتهاء صلاحية التسجيل';
$string['expiredaction_help'] = 'حدد الإجراء الذي يتم تنفيذه عند انتهاء صلاحية تسجيل المستخدم. يرجى ملاحظة أن بعض بيانات المستخدم والإعدادات يتم حذفها من المقرر أثناء إلغاء التسجيل.';

$string['submitted_info'] = 'معلومات التسجيل';
$string['privacy:metadata'] = 'لا يقوم ملحق تأكيد تسجيل المقرر بتخزين أي بيانات شخصية.';

$string['enrolperiod'] = 'مدة التسجيل';
$string['enrolperiod_desc'] = 'المدة الافتراضية التي يكون فيها التسجيل فعالاً. إذا تم تعيينها إلى صفر، ستكون مدة التسجيل غير محدودة افتراضياً.';
$string['enrolperiod_help'] = 'المدة التي يكون فيها التسجيل فعالاً، بدءاً من لحظة تسجيل المستخدم لنفسه. إذا تم تعطيلها، ستكون مدة التسجيل غير محدودة.';

$string['expirynotifyall'] = 'المعلم والمستخدم المسجل';
$string['expirynotifyenroller'] = 'المعلم فقط';

$string['group'] = 'تعيين المجموعة';
$string['group_help'] = 'يمكنك تعيين لا شيء أو مجموعات متعددة';

$string['opt_commentaryzone'] = 'حقل التعليق';
$string['opt_commentaryzone_help'] = 'نعم → تمكين حقل التعليق في نموذج التسجيل';

// رسائل انتهاء الصلاحية
$string['expirymessageenrollersubject'] = 'إشعار انتهاء صلاحية تسجيل الطلب';
$string['expirymessageenrollerbody'] = 'سينتهي تسجيل الطلب في المقرر "{$a->course}" خلال {$a->threshold} للمستخدمين التاليين:

    {$a->users}

لتمديد تسجيلهم، انتقل إلى {$a->extendurl}';
$string['expirymessageenrolledsubject'] = 'إشعار انتهاء صلاحية تسجيل الطلب';
$string['expirymessageenrolledbody'] = 'عزيزي/عزيزتي {$a->user},

هذا إشعار بأن تسجيلك في المقرر "{$a->course}" سينتهي في {$a->timeend}.

إذا كنت بحاجة إلى مساعدة، يرجى الاتصال بـ {$a->enroller}.';

$string['sendexpirynotificationstask'] = "مهمة إرسال إشعارات انتهاء صلاحية تسجيل الطلب";

$string['messageprovider:expiry_notification'] = 'إشعارات انتهاء صلاحية تسجيل الطلب';