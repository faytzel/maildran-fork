<?php

return [

    'auth' => [
        'register' => [
            'subject' => 'Registro correcto',
            'msg1'    => 'Te has registrado correctamente',
            'msg2'    => 'Acceder a',
            'msg3'    => 'Tu contraseña es',
        ],
        'reset' => [
            'subject' => 'Solicitud de cambio de contraseña',
            'msg1'    => '¿Quieres cambiar tu contraseña?',
            'msg2'    => 'Cambiar contraseña',
        ],
    ],
    'reminder' => [
        'remember' => [
            'subject' => '🔔 Recordatorio: :summary',
            'msg1'    => 'Recordatorio',
            'msg2'    => 'No te olvides de',
            'msg3'    => '¿Te lo recuerdo de nuevo en otro momento?',
            'msg4'    => 'Posponer',
        ],
        'create' => [
            'subject' => '💾 Recordatorio guardado: :summary',
            'msg1'    => 'Recordatorio guardado',
            'msg2'    => 'Tu recordatorio',
            'msg3'    => 'Ha sido guardado, y se te notificará el',
            'msg4'    => '¿La fecha del recordatorio no se ha guardado correctamente?',
            'msg5'    => 'Contacta para mejorarlo',
            'msg6'    => 'Mi fecha no se ha guardado correctamente',
            'msg7'    => 'Al guardar un recordatorio con el asunto/fecha ":subject" no se guardó correctamente',
        ],
        'dateInvalid' => [
            'subject' => '❌ Recordatorio inválido: :summary',
            'msg1'    => 'El formato de fecha del recordatorio no es correcto',
            'msg2'    => 'Indica la fecha en el asunto del email usando un formato válido de la',
            'msg3'    => 'Asunto',
            'msg4'    => 'Recordatorio',
            'msg5'    => '¿Quieres que MailDran soporte tu formato de fecha?',
            'msg6'    => 'Contacta para mejorarlo',
            'msg7'    => 'Mi formato de fecha no es soportado',
            'msg8'    => 'Me gustaría que MailDran soportara el formato de fecha ":subject"',
            'msg9'    => 'página de ayuda',
            'msg10'   => 'Editar email y volver a enviar',
        ],
        'empty' => [
            'subject' => '❌ Recordatorio inválido: :summary',
            'msg1'    => 'Debes escribir en el email lo que quieres recordar',
            'msg2'    => 'Asunto',
            'msg3'    => 'Recordatorio',
            'msg4'    => 'Vacío',
        ],
    ],
    'contact' => [
        'create' => [
            'subject' => 'Contacto',
            'msg1'    => 'Contacto',
            'msg2'    => 'Asunto',
            'msg3'    => 'Nombre',
            'msg4'    => 'Email',
            'msg5'    => 'Mensaje',
        ],
    ],
    'template' => [
        'msg1' => '¿Tienes alguna duda, sugerencia o quieres conocer las novedades de MailDran?',
        'msg2' => 'Únete al',
        'msg3' => 'canal de Telegram',
        'msg4' => 'o al',
        'msg5' => 'boletín de noticias',
    ],

];
