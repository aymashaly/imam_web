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
    [
        'eventname' => '\core\event\user_enrolment_created',
        'callback' => 'local_mist\invoicing\observer::user_enrolled',
        'includefile' => '/local/mist/classes/invoicing/observer.php'
    ],
    [
        'eventname' => '\local_mist\event\course_transfer_created',
        'callback' => 'local_mist\invoicing\observer::course_transfer',
        'includefile' => '/local/mist/classes/invoicing/observer.php'
    ],
    [
        'eventname' => '\local_mist\event\extra_fee_created',
        'callback' => 'local_mist\invoicing\observer::extra_fee_triggered',
        'includefile' => '/local/mist/classes/invoicing/observer.php'
    ]
];
