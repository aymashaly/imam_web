<?php
defined('MOODLE_INTERNAL') || die();

function local_mist_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    require_login();

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    $itemid = array_shift($args);
    $filename = array_pop($args);
    $filepath = '/' . implode('/', $args) . '/';

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_mist', $filearea, $itemid, $filepath, $filename);

    if (!$file || $file->is_directory()) {
        send_file_not_found();
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}
