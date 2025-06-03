<?php

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname'   => '\core\event\course_updated',
        'callback'    => 'local_mist_observer::course_updated',
        'includefile' => '/local/mist/classes/observer.php',
        'priority'    => 9999,
        'internal'    => false,
    ],
];
