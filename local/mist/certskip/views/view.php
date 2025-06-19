<?php
require_once(__DIR__ . '/../../../../config.php');
require_login();
$context = context_system::instance();

if (!is_siteadmin()) {
    throw new required_capability_exception($context, 'moodle/site:config', 'nopermissions', '');
}

global $DB, $OUTPUT, $PAGE;

// Get request id from URL
$id = required_param('id', PARAM_INT);

$PAGE->set_url(new moodle_url('/local/mist/certskip/views/view.php', ['id' => $id]));
$PAGE->set_context($context);
$PAGE->set_title('Certificate Skip Request');
$PAGE->set_heading('Certificate Skip Request');

echo $OUTPUT->header();
if(is_siteadmin()){
    echo html_writer::link(
        new moodle_url('/local/mist/certskip/index.php'),
        get_string('Back to List','local_mist')
    );
}else{
    echo html_writer::link(
        new moodle_url('/local/mist/certskip/views/myrequests.php'),
        get_string('Back to List','local_mist')
    );
}
echo $OUTPUT->heading(get_string('certskiprequest', 'local_mist') . ' #' . $id);

// Fetch the request
$request = $DB->get_record('local_mist_certskip', ['id' => $id], '*', IGNORE_MISSING);

if (!$request) {
    echo $OUTPUT->notification('Request not found.', 'notifyproblem');
    echo $OUTPUT->footer();
    exit;
}

$user = $DB->get_record('user', ['id' => $request->userid], '*', MUST_EXIST);
$course = $DB->get_record('course', ['id' => $request->courseid], '*', MUST_EXIST);


$filelinks = '-';
if (!empty($request->file_path)) {
    $url = new  moodle_url($request->file_path);

    $filelinks = html_writer::link($url, get_string('view_files','local_mist'),[
        "target" => "_blank"
    ]);
}

echo html_writer::start_tag('table', ['class' => 'generaltable']);
echo html_writer::start_tag('tbody');
echo html_writer::tag('tr',
    html_writer::tag('th', get_string('ID','local_mist')) .
    html_writer::tag('td', '#'.$request->id)
);
echo html_writer::tag('tr',
    html_writer::tag('th', get_string('user','local_mist')) .
    html_writer::tag('td', fullname($user))
);
echo html_writer::tag('tr',
    html_writer::tag('th', get_string('course','local_mist')) .
    html_writer::tag('td', $course->fullname)
);
echo html_writer::tag('tr',
    html_writer::tag('th', get_string('certificate_name','local_mist')) .
    html_writer::tag('td', $request->certificate_name)
);
echo html_writer::tag('tr',
    html_writer::tag('th', get_string('issuing_body','local_mist')) .
    html_writer::tag('td', $request->issuing_body)
);
echo html_writer::tag('tr',
    html_writer::tag('th', get_string('date_issued','local_mist')) .
    html_writer::tag('td', userdate($request->date_issued))
);
echo html_writer::tag('tr',
    html_writer::tag('th', get_string('request_date','local_mist')) .
    html_writer::tag('td', userdate($request->timerequested))
);
echo html_writer::tag('tr',
    html_writer::tag('th', get_string('file(s)','local_mist')) .
    html_writer::tag('td', $filelinks ?: '-') 
);
echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');
if($request->request_status == 'pending' and is_siteadmin()){
    $approveurl = new moodle_url('/local/mist/certskip/action.php', ['action' => 'approve', 'id' => $request->id]);
    $refuseurl = new moodle_url('/local/mist/certskip/action.php', ['action' => 'refuse', 'id' => $request->id]);

    echo html_writer::link($approveurl, get_string('approve','local_mist'), [
        'class' => 'btn btn-success',
        'onclick' => "return confirm('".get_string('Approve this request?','local_mist')."');"
    ]);

    echo html_writer::link($refuseurl, get_string('refuse','local_mist'), [
        'class' => 'btn btn-danger',
        'onclick' => "return confirm('".get_string('Refuse this request?','local_mist')."');"
    ]);
}

echo $OUTPUT->footer();