<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], []],
    'app_geolocalizacion_index' => [[], ['_controller' => 'App\\Controller\\GeolocalizacionController::index'], [], [['text', '/geolocalizacion/']], [], []],
    'app_geolocalizacion_verestadisticas' => [[], ['_controller' => 'App\\Controller\\GeolocalizacionController::verEstadisticas'], [], [['text', '/geolocalizacion/estadisticas']], [], []],
];
