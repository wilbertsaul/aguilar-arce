<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Caché de consultas DNI / RUC
    |--------------------------------------------------------------------------
    |
    | La tabla `consultas_documento` es neutral: hoy vive en esta base de
    | datos y mañana puede apuntar a la BD compartida `consultas_pe` sin
    | cambiar el código (solo la conexión y CONSULTAS_KEY).
    |
    */

    'cache_key' => env('CONSULTAS_KEY', env('APP_KEY')),

    'ttl_dias' => (int) env('CONSULTAS_TTL_DIAS', 30),

    /*
    | Límites del simulador público. Una consulta resuelta desde caché no
    | consume cupo ni créditos: solo las consultas nuevas cuentan.
    */
    'por_ip_dia' => (int) env('CONSULTAS_POR_IP_DIA', 2),

    'global_dia' => (int) env('CONSULTAS_GLOBAL_DIA', 50),

    'rafaga_por_minuto' => (int) env('CONSULTAS_RAFAGA_MINUTO', 10),

];
