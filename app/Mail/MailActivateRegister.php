<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail Activacion Registro')
                    ->view('email.activate_register');
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

    /**
     * Get the data for the email.
     *
     * @return string
     */
    protected function get_data()
    {
        $email = LoginUser::select('email')->where("id", $this->id_registro)->first()->email;
        return $email; 
    }
}
