<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfiguracionData;
use App\Models\Transbank;
use App\Models\Compras;

use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

use App\Mail\ComprobanteCompra;
use Illuminate\Support\Facades\Mail;

class TransbankController extends Controller
{
    

    public function __construct()
    {
        if(state_production() == true){
            $cc =  ConfiguracionData::select("dato")->where("resultado", "tbk_cc")->get()->first()->dato;
            $api = ConfiguracionData::select("dato")->where("resultado", "tbk_api-key")->get()->first()->dato;
            WebpayPlus::configureForProduction($cc, $api);
        }else{
            WebpayPlus::configureForTesting();            
        }
    }

    public function iniciar_compra(Request $request)
    {

        $total = Compras::select("total")->where("id", $request->id_compra)->get()->first()->total;

        $tbk = new Transbank;
        $tbk->session_id = session()->getId();
        $tbk->id_compras = $request->id_compra;
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
            url('/').'/api/confirmar_pago'
        );

        Transbank::where("id", $tbk->id)->update(["token" => $transaccion->getToken()]);

        $url = $transaccion->getUrl().'?token_ws='.$transaccion->getToken();
        return $url;
    }

    public function confirmar_pago(Request $request)
    {
        $confirmacion = (new Transaction)->commit($request->get("token_ws"));

        if($confirmacion->isApproved()){
            $id_order = $confirmacion->buyOrder;
            // $tbk = Transbank::where("id", $id_order)->first();
            Transbank::where("id", $id_order)
                        ->update([
                            "responseCode" => $confirmacion->responseCode,
                            "authorizationCode" => $confirmacion->authorizationCode,
                            "paymentTypeCode" => $confirmacion->paymentTypeCode,
                            "installmentsNumber" => $confirmacion->installmentsNumber,
                            "installmentsAmount" => $confirmacion->installmentsAmount == null ? 0 : $confirmacion->installmentsAmount,
                            "cardNumber" => $confirmacion->cardNumber,
                        ]);
            $id_compra = Transbank::select("id_compras")->where("id", $id_order)->get()->first()->id_compras;
            Compras::where("id", $id_compra)->update(["id_tbk" => $id_order]);
            $email = Compras::select('email')->where("id", $id_compra)->get()->first()->email;
            // ? busca los productos en el carrito para poder agregarlos a COMPRAS_PRODUCTOS
            $compras_productos = 


            // ? se debe enviar el correo
            $correo = new ComprobanteCompra;


            Mail::to($email)->send($correo);
            // ? enviar a los responsables

            // ? eliminar el carrito enviado

            // return redirect("./pgo-tbk");

        }else{
            return redirect("./pgo-result");
            
        }

    }
   
}

 //  tarjeta de debit aprobadad
    // 4051884239937763


// {
//     "vci": "TSY",
//     "status": "AUTHORIZED",
//     "responseCode": 0,
//     "amount": 683905,
//     "authorizationCode": 1415,
//     "paymentTypeCode": "VD",
//     "accountingDate": "0227",
//     "installmentsNumber": 0, -> ctas
//     "installmentsAmount": null, -> cantidad cuotas
//     "sessionId": "PDtEybXDK9qR94UAHKHW7TTREvrX2YBwf1PAZBxj",
//     "buyOrder": 24,
//     "cardNumber": 7763,
//     "cardDetail": {
//       "card_number": 7763
//     },
//     "transactionDate": "2023-02-27T07:20:41.126Z",
//     "balance": null
//   }