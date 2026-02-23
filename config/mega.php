<?php

return [
    'enabled' => env('MEGA_ENABLED', true),           // activer/désactiver le bypass dev
    'envs'    => ['local','staging', 'production'],                 // environnements autorisés
    'allow_in_production' => env('MEGA_ALLOW_PROD', true),
    'emails'  => array_filter(array_map('trim', explode(',', env('MEGA_EMAILS', 'ever21321@gmail.com')))),
];
