<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TravailRejeteNotification extends Notification
{
    use Queueable;

    protected $motif;

    public function __construct($motif)
    {
        $this->motif = $motif;
    }

    public function via($notifiable)
    {
        return ['database']; // Enregistrer la notification dans la base
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Votre TFC a été rejeté.',
            'motif' => $this->motif,
        ];
    }
}
