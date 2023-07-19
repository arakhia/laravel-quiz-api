<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MissedVocabulary extends Notification
{
    use Queueable;

    protected $vocabularies;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vocabularies)
    {
        $this->vocabularies = $vocabularies;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'data' => '!!Vocabulary Reminder!! you have missed the following vocabularies: \n ' . implode(", ", $this->vocabularies)
        ];
    }
}
