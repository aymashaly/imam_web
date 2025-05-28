<?php
require_once(__DIR__ . '/config.php');

$slug = required_param('slug', PARAM_ALPHANUMEXT);
$PAGE->set_url(new moodle_url('/local/mist/submit_form.php', ['slug' => $slug]));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Submit Form");
$PAGE->set_heading("Submit Form");

// Load required JS
$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
$PAGE->requires->js(new moodle_url('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js'), true);
$PAGE->requires->js(new moodle_url('/local/mist/assets/form-render.min.js'), true);

global $DB, $OUTPUT, $USER;

// Get the form
$form = $DB->get_record('formbuilder_forms', ['slug' => $slug], '*', IGNORE_MISSING);

if (!$form) {
    throw new moodle_exception("Form not found.");
}

// Handle submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formdata = required_param('formdata', PARAM_RAW); // Expect JSON
    $record = new stdClass();
    $record->formid = $form->id;
    $record->data = $formdata;
    $record->timesubmitted = time();
    $DB->insert_record('formbuilder_submissions', $record);

    echo $OUTPUT->header();
    echo html_writer::tag('h2', 'Thank you for submitting the form!');
    echo $OUTPUT->footer();
    exit;
}

echo $OUTPUT->header();
?>

<h2><?php echo format_string($form->name); ?></h2>
<p><?php echo format_text($form->description, FORMAT_HTML); ?></p>

<form id="dynamic-form" method="post">
    <div id="fb-render"></div>
    <input type="hidden" name="formdata" id="formdata">
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fbRender = $('#fb-render').formRender({
            dataType: 'json',
            formData: <?php echo json_encode($form->jsonschema); ?>
        });

        document.getElementById('dynamic-form').addEventListener('submit', function (e) {
            const formJSON = $(this).serializeArray();
            const formatted = {};
            formJSON.forEach(item => {
                formatted[item.name] = item.value;
            });
            document.getElementById('formdata').value = JSON.stringify(formatted);
        });
    });
</script>

<?php
echo $OUTPUT->footer();
