<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    use Queueable;

    private string $password_notif;
    private string $message;
    private string $user_name;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $password_notif, string $message, string $user_name)
    {
        $this->password_notif= $password_notif;
        $this->message= $message;
        $this->user_name= $user_name;
    }
 
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Welcome '.$this->user_name." !")
                    // ->action('Notification Action', url('/'))
                    
                    ->line($this->message)
                    ->line('Your temporary password ( '.$this->password_notif." )")
                    ->action('Go to the site', 'http://laravel.kindergarten.two/');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
