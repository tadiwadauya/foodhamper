<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FoodDistributedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $distributor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($distributor)
    {
        return $this->distributor = $distributor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.food_dist')
                    ->subject('Food Humber Distribution');
    }
}
