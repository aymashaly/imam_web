<?php
/*
@edmaRef: @block_edma/block.php
*/

defined('MOODLE_INTERNAL') || die();

// print_object($this);
$edmaBlockType = $this->instance->blockname;

$edmaCollectionFullwidthTop =  array(
    "edma_banner_1",
    "edma_course_filter",
    "edma_course_slider",
    "edma_categories",
    "edma_about_area",
    "edma_features_area",
    "edma_testimonial_area",
    "edma_partners",
    "edma_about_area_two",
    "edma_about_area_three",
    "edma_blog_area",
    "edma_authors_area",
    "edma_faq",
    "edma_testimonial_area_two",
    "edma_contact_features",
    "edma_contact",
);

$edmaCollectionAboveContent =  array(
    "edma_contact_form",
    "edma_course_desc",
);

$edmaCollectionBelowContent =  array(
    "edma_course_rating",
    "edma_more_courses",
    "edma_course_instructor",
);

$edmaCollection = array_merge($edmaCollectionFullwidthTop, $edmaCollectionAboveContent, $edmaCollectionBelowContent);

if (empty($this->config)) {
    if(in_array($edmaBlockType, $edmaCollectionFullwidthTop)) {
        $this->instance->defaultregion = 'fullwidth-top';
        $this->instance->region = 'fullwidth-top';
        $DB->update_record('block_instances', $this->instance);
    }
    if(in_array($edmaBlockType, $edmaCollectionAboveContent)) {
        $this->instance->defaultregion = 'above-content';
        $this->instance->region = 'above-content';
        $DB->update_record('block_instances', $this->instance);
    }
    if(in_array($edmaBlockType, $edmaCollectionBelowContent)) {
        $this->instance->defaultregion = 'below-content';
        $this->instance->region = 'below-content';
        $DB->update_record('block_instances', $this->instance);
    }
}
