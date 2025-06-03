<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Extend the global navigation with the mist plugin node
 *
 * @param navigation_node $navref
 */
function local_mist_extend_navigation(global_navigation $navref) {
    global $PAGE, $USER;

    if (is_siteadmin($USER)) {
        $url = new moodle_url('/local/mist/index.php');
        $node = navigation_node::create(
            get_string('pluginname', 'local_mist'),
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'local_mist'
        );
        $navref->add_node($node);
    }
}
function local_mist_is_course_full($courseid) {
    global $DB;

    $context = context_course::instance($courseid);
    $enrolled = get_enrolled_users($context, '', 0, 'u.id');
    $enrolledcount = count($enrolled);

    $maxcapacity = 20; // TODO

    return $enrolledcount >= (int)$maxcapacity;
}
