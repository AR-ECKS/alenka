<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DesviacionNotificacion extends Notification
{
    use Queueable;

    protected $desviacion;

    public function __construct($desviacion)
    {
        $this->desviacion = $desviacion;
    }

    public function via($notifiable)
    {
        return ['database']; // Puedes añadir 'mail', 'sms', etc.
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Hubo una pérdida de ' . $this->desviacion . ' kilos en la mezcla.',
        ];
    }
}


