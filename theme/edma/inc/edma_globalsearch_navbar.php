<?php
defined('MOODLE_INTERNAL') || die();

$edma_globalsearch_navbar = '';

$placeholder      = get_config('theme_edma', 'search_placeholder');

if (\core_search\manager::is_global_search_enabled() === false) {
    $placeholder = get_string('globalsearchdisabled', 'search');
}

$url = new moodle_url('/search/index.php');

$edma_globalsearch_navbar .= html_writer::start_tag('form', array('class' => 'search-form','action' => $url->out()));
$edma_globalsearch_navbar .= html_writer::start_tag('fieldset');

// Input.
$inputoptions = array('id' => 'searchform_search', 'name' => 'q', 'class' => 'form-control', 'placeholder' => $placeholder, 'type' => 'text',);
$edma_globalsearch_navbar .= html_writer::empty_tag('input', $inputoptions);

// Context id.
if ($this->page->context && $this->page->context->contextlevel !== CONTEXT_SYSTEM) {
    $edma_globalsearch_navbar .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'context', 'value' => $this->page->context->id]);
}
// Search button.
$edma_globalsearch_navbar .= '<button type="submit" class="src-btn"><img src="'.$CFG->wwwroot.'/theme/edma/pix/search-icon.svg""></button>';
$edma_globalsearch_navbar .= html_writer::end_tag('fieldset');
$edma_globalsearch_navbar .= html_writer::end_tag('form');
