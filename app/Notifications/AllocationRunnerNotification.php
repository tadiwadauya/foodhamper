<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AllocationRunnerNotification extends Notification
{
    use Queueable;

    public $allocation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($allocation)
    {
        return $this->allocation = $allocation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->subject('Humbers monthly allocation for Whelson Employees .')
                    ->line($this->allocation['body'])
                    ->action('Visit Application', url('http://127.0.0.1:8000/allocations'))
                    ->line('Thank you for using Whelson Food Humbers!');
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

    public function toDatabase($notifiable)
    {
        return [
            'data' => $this->allocation['body'],
        ];
    }
}
