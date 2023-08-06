<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class NewOrder extends Notification
{
    public $title;
    public $body;
    public $packet;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $body, $packet = [])
    {
        //
        $this->title = $title;
        $this->body = $body;
        $this->packet = $packet;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage())
            // ->id($notification->id)
            ->title($this->title)
            ->icon(url('/img/push_notification.png'))
            ->body($this->body)
            ->action('View account', 'view_account')
            ->data($this->packet);
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
