<?php

return [

    'default' => 'Envía y recibe recordatorios por email',
    'page'    => 'Página',
    'tagline' => ' | ' . Config::get('app.name'),

    /*
    |--------------------------------------------------------------------------
    | Por rutas
    |--------------------------------------------------------------------------
    */

    'routes' => [
        'home-index'            => 'Envía y recibe recordatorios por email',
        'login'                 => 'Acceso',
        'register'              => 'Registro',
        'register-success'      => 'Registro completado',
        'password-request'      => '¿Has olvidado tu contraseña?',
        'password-reset'        => 'Cambiar contraseña',
        'help-index'            => 'Ayuda',
        'help-reminderNew'      => 'Ayuda: ¿Cómo crear un recordatorio?',
        'help-reminderDatetime' => 'Ayuda: Formatos de fechas compatibles',
        'help-workflow'         => 'Ayuda: Usa MailDran junto con Workflow',
        'help-bookmark'         => 'Ayuda: Marcador de navegador',
        'legal-tos'             => 'Aviso legal y condiciones de uso',
        'legal-privacy'         => 'Política de privacidad',
        'legal-cookie'          => 'Política de cookies',
        'reminder-index'        => 'Recordatorios pendientes',
        'reminder-notified'     => 'Recordatorios notificados',
        'contact-new'           => 'Contacto',
        'contact-success'       => 'Mensaje enviado',
        'openMetrics-index'     => 'Estadísticas',
        'settings-user'         => 'Ajustes de usuario',
        'settings-reminder'     => 'Ajustes de recordatorio',
    ],

    /*
    |--------------------------------------------------------------------------
    | Paginas de errores
    |--------------------------------------------------------------------------
    */

    'errors' => [
        '500' => 'Hubo un error',
        '503' => 'Mantenimiento',
        '403' => 'Contenido bloqueado',
        '404' => 'Página no encontrada',
    ],

];
