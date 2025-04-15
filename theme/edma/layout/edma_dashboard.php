<?php
defined('MOODLE_INTERNAL') || die();
echo $OUTPUT->doctype();

include($CFG->dirroot . '/theme/edma/inc/edma_themehandler.php');

$bodyattributes = $OUTPUT->body_attributes();
include($CFG->dirroot . '/theme/edma/inc/edma_themehandler_context.php');

echo $OUTPUT->render_from_template('theme_edma/edma_dashboard', $templatecontext);