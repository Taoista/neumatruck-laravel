<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ComprasAuxiliar;
use App\Models\TransbankAuxiliar;
use App\Models\ConfiguracionEmail;
use App\Models\TipoTarjeta;
use Carbon\Carbon;

class PagoAuxiliarMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $id_compra;

    public $compra;
    public $transbank;

    public $year;

    public $tipo_tarjeta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_compra)
    {
        $this->id_compra = $id_compra;

        $this->compra = $this->data_production();
        
        $this->transbank = $this->data_tbk();

        $this->year = Carbon::now()->year;

        $cod = $this->transbank->paymentTypeCode;

        $this->tipo_tarjeta = $this->tipo_tarjeta($cod);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Pago Auxiliar Mailable',
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
            view: 'email.pago_auxiliar',
        );
    }
    // http://neumatruck.test/transbank-pago
    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    function data_production()
    {
        $id_compra = $this->id_compra;

        $compras = ComprasAuxiliar::where('id', $id_compra)->first();

        return $compras;

    }

    function data_tbk()
    {
        $id_compra = $this->id_compra;

        $data = TransbankAuxiliar::where('id_compras', $id_compra)->first();

        return $data;
    }

    function tipo_tarjeta($cod)
    {   
        $data = TipoTarjeta::where('cod', $cod)->first()->name;
        return $data;
    }

      //  tarjeta de debit aprobadad
    // 4051884239937763
// tarjeta de creidto
//     4051885600446623
// CVV 123


}
