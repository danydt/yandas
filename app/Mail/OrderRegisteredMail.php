<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $order_code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $order_code)
    {
        $this->order_code = $order_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouvelle commande')->view('mail.new-order');
    }
}
