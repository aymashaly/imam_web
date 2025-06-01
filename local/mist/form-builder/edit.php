<?php
require_once(__DIR__ . '/../../../config.php');

require_login();
if (!is_siteadmin()) {
    throw new required_capability_exception(context_system::instance(), 'moodle/site:config', 'nopermissions', '');
}
$id = required_param('id', PARAM_INT);
$form = $DB->get_record('formbuilder_forms', ['id' => $id], '*', MUST_EXIST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonschema = required_param('formjson', PARAM_RAW);
    
    $form->jsonschema = $jsonschema;
    $DB->update_record('formbuilder_forms', $form);

    redirect(new moodle_url('/local/mist/form-builder/index.php'), "Form updated successfully.", 2);
}


$PAGE->set_url(new moodle_url('/local/mist/edit.php', ['id' => $id]));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Edit Form");
$PAGE->set_heading("Edit Form");

$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
$PAGE->requires->js(new moodle_url('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js'), true);
$PAGE->requires->js(new moodle_url('/local/mist/assets/form-builder.min.js'), true);

echo $OUTPUT->header();
?>

<h2>Edit Form: <?= format_string($form->name) ?></h2>

<form method="post">
    <textarea id="fb-template" name="formjson" style="display:none;"><?php echo $form->jsonschema; ?></textarea>
    <div id="fb-editor"></div>
    <br>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>

<script>
    jQuery(function($) {
        var formData = $('#fb-template').val();
        var fbEditor = $('#fb-editor').formBuilder({
            formData: formData
        });

        $('form').on('submit', function() {
            $('#fb-template').val(fbEditor.actions.getData('json'));
        });
    });
</script>

<?php

echo $OUTPUT->footer();
