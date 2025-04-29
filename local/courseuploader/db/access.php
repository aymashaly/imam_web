<?php

$capabilities = [
    'local/courseuploader:upload' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => ['manager' => CAP_ALLOW]
    ],
];
