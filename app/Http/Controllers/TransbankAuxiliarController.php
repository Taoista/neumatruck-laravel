<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfiguracionData;
use App\Models\TransbankAuxiliar;
use App\Models\ComprasAuxiliar;
use App\Models\ConfiguracionEmail;


use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

use App\Mail\PagoAuxiliarMailable;
use Illuminate\Support\Facades\Mail;

class TransbankAuxiliarController extends Controller
{
    
    public function __construct()
    {
        if(state_production() == true){
            $cc =  ConfiguracionData::select("result")->where("data", "tbk_cc_12")->get()->first()->result;
            $api = ConfiguracionData::select("result")->where("data", "tbk_apip_key_12")->get()->first()->result;

            WebpayPlus::configureForProduction($cc, $api);
        }else{
            WebpayPlus::configureForTesting();
        }
    }

    // * pantalla 
    function transbank_pago()
    {
        $total = ConfiguracionData::select("result")->where("data", "monto_total_auxiliar")->get()->first()->result;

        $pago = format_money($total);

        return view("auxiliar.auxiliar", compact('pago'));
    }

    // todo: actualizar token y estado en compras_auxiliar


    function iniciar_compra(Request $request)
    {
        $total = ConfiguracionData::select("result")->where("data", "monto_total_auxiliar")->get()->first()->result;

        // $id = $this->getDataMaxId();

        $compra =  new ComprasAuxiliar();
        $compra->rut = $request->rut;
        $compra->nombre = strtolower($request->nombre.' '.$request->apellido);
        $compra->email = strtolower($request->email);
        $compra->telefono = $request->telefono;
        $compra->contacto = strtolower($request->nombre.' '.$request->apellido);
        $compra->direccion = strtolower($request->direccion);
        $compra->nota = strtolower($request->nota);
        $compra->neto = 0;
        $compra->iva = 0;
        $compra->total = $total;
        $compra->save();

        $tbk = new TransbankAuxiliar();
        $tbk->session_id = session()->getId();
        $tbk->id_compras = $compra->id;
        $tbk->total = $total;
        $tbk->save();


       return $this->start_web_pay_plus($tbk);

    }

    public function start_web_pay_plus($tbk)
    {

        $transaccion = (new Transaction)->create(
            $tbk->id,
            $tbk->session_id,
            $tbk->total,
            url('/').'/confirmar_pago'
        );

        TransbankAuxiliar::where("id", $tbk->id)->update(["token" => $transaccion->getToken()]);

        $url = $transaccion->getUrl().'?token_ws='.$transaccion->getToken();
        return $url;
    }

    public function confirmar_pago(Request $request)
    {

        try {
            $confirmacion = (new Transaction)->commit($request->get("token_ws"));

            if($confirmacion->isApproved()){

                $id_order = $confirmacion->buyOrder;

                TransbankAuxiliar::where("id", $id_order)
                            ->update([
                                "responseCode" => $confirmacion->responseCode,
                                "authorizationCode" => $confirmacion->authorizationCode,
                                "paymentTypeCode" => $confirmacion->paymentTypeCode,
                                "installmentsNumber" => $confirmacion->installmentsNumber,
                                "installmentsAmount" => $confirmacion->installmentsAmount == null ? 0 : $confirmacion->installmentsAmount,
                                "cardNumber" => $confirmacion->cardNumber,
                            ]);

                $id_compra = TransbankAuxiliar::select("id_compras")->where("id", $id_order)->get()->first()->id_compras;
                ComprasAuxiliar::where("id", $id_compra)
                                    ->update([
                                        "id_tbk" => $id_order,
                                        "estado_compra" => 2
                                    ]);       

                $email = ComprasAuxiliar::select('email', 'token')->where("id", $id_compra)->first();
                
                // ? enviar email
                $correo = new PagoAuxiliarMailable($id_compra);
                Mail::to($email->email)->send($correo);
                // ? admin
                $emails_admin = $this->get_emails_admins();
                foreach($emails_admin AS $item){
                    $correo = new PagoAuxiliarMailable($id_compra);
                    Mail::to($item->email)->send($correo);
                }
                return redirect('https://google.com');
            }else{
                return redirect('https://google.com');
            }
        } catch (\Throwable $th) {
            return redirect('https://google.com');
        }


    }

    function get_emails_admins()
    {
        return ConfiguracionEmail::select("email")->where("estado", 1)->get();
    }

    

     //  tarjeta de debit aprobadad
    // 4051884239937763
// tarjeta de creidto
//     4051885600446623
// CVV 123

}
