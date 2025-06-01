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
echo html_writer::link(
    new moodle_url('/local/mist/certskip/index.php'),
    '&larr; Back to List'
);
echo $OUTPUT->heading('Certificate Skip Request');

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
    $context = context_system::instance();
    $component = 'local_mist';
    $filearea = 'attachment';
    $itemid = $request->id;
    $filename = $request->file_path; // e.g., "myfile.pdf"

    $url = moodle_url::make_pluginfile_url(
        $context->id,
        $component,
        $filearea,
        $itemid,
        '/',
        $filename
    );

    echo html_writer::link($url, $filename);


    $filelinks = html_writer::link($url, $filename);
}

echo html_writer::start_tag('table', ['class' => 'generaltable']);
echo html_writer::start_tag('tbody');
echo html_writer::tag('tr',
    html_writer::tag('th', 'ID') .
    html_writer::tag('td', '#'.$request->id)
);
echo html_writer::tag('tr',
    html_writer::tag('th', 'User') .
    html_writer::tag('td', fullname($user))
);
echo html_writer::tag('tr',
    html_writer::tag('th', 'Course') .
    html_writer::tag('td', $course->fullname)
);
echo html_writer::tag('tr',
    html_writer::tag('th', 'Certificate Name') .
    html_writer::tag('td', $request->certificate_name)
);
echo html_writer::tag('tr',
    html_writer::tag('th', 'Issuing Body') .
    html_writer::tag('td', $request->issuing_body)
);
echo html_writer::tag('tr',
    html_writer::tag('th', 'Date Issued') .
    html_writer::tag('td', userdate($request->date_issued))
);
echo html_writer::tag('tr',
    html_writer::tag('th', 'Request Date') .
    html_writer::tag('td', userdate($request->timerequested))
);
echo html_writer::tag('tr',
    html_writer::tag('th', 'File(s)') .
    html_writer::tag('td', $filelinks ?: '-') 
);
echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');
if($request->request_status == 'pending'){
    $approveurl = new moodle_url('/local/mist/certskip/action.php', ['action' => 'approve', 'id' => $request->id]);
    $refuseurl = new moodle_url('/local/mist/certskip/action.php', ['action' => 'refuse', 'id' => $request->id]);

    echo html_writer::link($approveurl, 'Approve', [
        'class' => 'btn btn-success',
        'onclick' => "return confirm('Approve this request?');"
    ]);

    echo html_writer::link($refuseurl, 'Refuse', [
        'class' => 'btn btn-danger',
        'onclick' => "return confirm('Refuse this request?');"
    ]);
}

echo $OUTPUT->footer();