<?php
require_once(__DIR__ . '/../../../config.php');
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/mist/form-builder/create.php'));
$PAGE->set_title('Create Form');
$PAGE->set_heading('Create New Form');
$PAGE->requires->js(new moodle_url('/local/mist/assets/form-builder.min.js'));

global $DB, $USER, $OUTPUT;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = required_param('name', PARAM_TEXT);
    $jsonschema = required_param('jsonschema', PARAM_RAW); // Expecting raw JSON from JS

    $record = new stdClass();
    $record->name = $name;
    $record->slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $name), '-'));
    $record->jsonschema = $jsonschema;
    $record->timecreated = time();
    $record->createdby = $USER->id;

    $DB->insert_record('formbuilder_forms', $record);

    redirect(new moodle_url('/local/mist/form-builder/index.php'), 'Form created successfully!', 2);
}

// Render the form builder UI
echo $OUTPUT->header();
echo html_writer::link(
    new moodle_url('/local/mist/form-builder/index.php'),
    '&larr; Back to Forms'
);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI: required for drag/drop & sortable -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<h2>Create New Form</h2>
<div class="form-group">
    <label>Build your form</label>
    <div id="formbuilder" style="border: 1px solid #ccc; padding: 10px; min-height: 200px;"></div>
</div>
<form method="post" id="formbuilder-form">    
    <div class="form-group">
        <label for="form-name">Form Name</label>
        <input type="text" name="name" id="form-name" class="form-control" required>
    </div>
    <input type="hidden" name="jsonschema" id="jsonschema" required>
    <br>
    <button type="submit" class="btn btn-primary">Save Form</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formBuilder = $('#formbuilder').formBuilder();

        const form = document.getElementById('formbuilder-form');
        form.addEventListener('submit', function (e) {
            const jsonData = formBuilder.actions.getData('json', true);
            document.getElementById('jsonschema').value = jsonData;
        });
    });
</script>

<?php
echo $OUTPUT->footer();
