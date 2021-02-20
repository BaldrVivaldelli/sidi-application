<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordToken extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $token;
        public function __construct($token) {
            $this->token = $token;
        }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    
                    ->from('noreply@sidi-support.com','noreply@sidi-support.com')
                    ->subject("Blanqueo de contraseña")
                    ->greeting('Hola')
                    ->line("Hace click en el siguiente link para obtener una nueva contraseña.")
                    ->line("El siguiente mail es valido solo durante 60 minutos.")
                    ->action('Cambiar tu contraseña ', config('app.url').'/password/reset/'. $this->token)
                    ->line('Gracias')
                    ->line('SIDI');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
