<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendParentNotification extends Notification
{
    use Queueable;

    private string $name;
    private string $text_email;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $name, string $text_email)
    {
        //
        $this->name= $name;
        $this->text_email= $text_email;
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
                    ->line('Dear '.$this->name." !")
                    ->line('You are contacted by the administration of the kindergarten Happy Times')
                    ->line($this->text_email);
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
