<?php

namespace App\Notifications;

use App\Models\UserPending;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisterNotification extends Notification
{
    use Queueable;

    private $userPending;

    /**
     * Create a new notification instance.
     *
     * @param UserPending $userPending
     * @return void
     */
    public function __construct(UserPending $userPending)
    {
        $this->userPending = $userPending;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Enable your account using the button down bellow.')
            ->action('Enable Account', url('api/v1/user/activate/' . $this->userPending->code))
            ->line('Thanks for choosing our server!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
