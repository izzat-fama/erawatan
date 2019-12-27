<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TuntutanBaru extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The tuntutan instance.
     *
     * @var Tuntutan
     */
    public $tuntutan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tuntutan)
    {
        $this->tuntutan = $tuntutan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.tuntutan.baru')
        ->with([
            'resit' => $this->tuntutan->ertuntutannoresit,
            'nostaf' => $this->tuntutan->employeeno
        ]);
    }
}
