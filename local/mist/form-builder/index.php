<?php
require_once(__DIR__ . '/../../../config.php');
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/mist/form-builder/index.php'));
$PAGE->set_title(get_string('formbuildertitle', 'local_mist'));
$PAGE->set_heading(get_string('formbuildertitle', 'local_mist'));

global $DB, $OUTPUT;

// Fetch all forms
$forms = $DB->get_records('formbuilder_forms');
echo $OUTPUT->header();
echo html_writer::link(
    new moodle_url('/local/mist/index.php'),
    '&larr; Back to Board'
);
echo html_writer::tag('h2', get_string('formbuildertitle', 'local_mist'));

// Create button
$createurl = new moodle_url('/local/mist/form-builder/create.php');
echo $OUTPUT->single_button($createurl, get_string('createform', 'local_mist'), 'get', ['class' => 'btn btn-primary']);

// Display forms table
if (!empty($forms)) {
    $table = new html_table();
    $table->head = ['ID', 'Name','Slug', 'Created By', 'Created At','link'];
    foreach ($forms as $form) {
        $row = [];
        $row[] = $form->id;
        $row[] = format_string($form->name);
        $row[] = format_string($form->slug);
        $row[] = fullname(core_user::get_user($form->createdby));
        $row[] = userdate($form->timecreated);
        $submiturl = new moodle_url('/submit_form.php', ['slug' => $form->slug]);
        $row[] = html_writer::tag(
            'button',
            get_string('copylink', 'local_mist'),
            [
            'type' => 'button',
            'class' => 'btn btn-secondary copy-link-btn',
            'data-link' => $submiturl->out(false)
            ]
        );
        $answersurl = new moodle_url('/local/mist/form-builder/answers.php', ['formid' => $form->id]);
        $row[] = html_writer::link($answersurl, get_string('viewanswers', 'local_mist'), ['class' => 'btn btn-info']);
        $table->data[] = $row;
    }
    echo html_writer::table($table);
} else {
    echo html_writer::tag('p', get_string('noforms', 'local_mist'));
}
?>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.copy-link-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const link = btn.getAttribute('data-link');
            if (ClipboardJS) {
                ClipboardJS.copy(link)
                btn.textContent = '<?php echo addslashes(get_string('copied', 'local_mist')); ?>';
                setTimeout(function() {
                    btn.textContent = '<?php echo addslashes(get_string('copylink', 'local_mist')); ?>';
                }, 1500);
            } else {
                alert('Clipboard API not supported.');
            }
        });
    });
});
</script>
<?php
echo $OUTPUT->footer();
