<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\LoginUser;

class MailActivateRegister extends Mailable
{
    use Queueable, SerializesModels;


    public $id_registro;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_registro)
    {
        $this->id_registro = base64_decode($id_registro);
        $this->email = $this->get_data();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Mail Activacion Registro',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.activate_register',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    function get_data()
    {
        $email = LoginUser::select('email')->where("id", $this->id_registro)->first()->email;
        return $email; 
    }

}
