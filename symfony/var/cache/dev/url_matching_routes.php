<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/geolocalizacion' => [[['_route' => 'app_geolocalizacion_index', '_controller' => 'App\\Controller\\GeolocalizacionController::index'], null, null, null, true, false, null]],
        '/geolocalizacion/estadisticas' => [[['_route' => 'app_geolocalizacion_verestadisticas', '_controller' => 'App\\Controller\\GeolocalizacionController::verEstadisticas'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
