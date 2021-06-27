<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Wimil\LighthouseGraphqlJwtAuth\Notifications\VerifyEmail;

class VerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $verificationUrl = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('登録が完了しました')
            ->view('emails.User.registration', [
                'name' => $this->user->name,
                'expired_time' => config('auth.passwords.users.expire'),
                'base_url' => config('app.front_url'),
                'verificationUrl' => $verificationUrl,
            ]);
    }
}
