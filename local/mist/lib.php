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
function local_mist_certskip_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel !== CONTEXT_SYSTEM) {
        return false;
    }

    if ($filearea !== 'attachment') {
        return false;
    }

    $itemid = array_shift($args); // $request->id
    $filename = array_pop($args);
    $filepath = '/' . implode('/', $args) . '/'; // usually just '/'

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_mist_certskip', 'attachment', $itemid, $filepath, $filename);

    if (!$file || $file->is_directory()) {
        return false;
    }

    // Optional: access control (capabilities, record ownership, etc.)

    send_stored_file($file, 0, 0, $forcedownload, $options);
}
