<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfiguracionData;
use App\Models\Transbank;
use App\Models\Compras;
use App\Models\Productos;
use App\Models\Carrito;
use App\Models\ComprasProductos;
use App\Models\ConfiguracionEmail;

use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

use App\Mail\ComprobanteCompra;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\ProductosController;

class TransbankController extends Controller
{
    public function __construct()
    {
        if(state_production() == true){
            $cc =  ConfiguracionData::select("result")->where("data", "tbk_cc")->get()->first()->result;
            $api = ConfiguracionData::select("result")->where("data", "tbk_apip_key")->get()->first()->result;

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

        try {
            $confirmacion = (new Transaction)->commit($request->get("token_ws"));

            if($confirmacion->isApproved()){
                $controller = new ProductosController();


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
                $compras_productos = Carrito::select("p.id", "carrito.cantidad", "p.codigo", "p.p_venta", "p.oferta")
                                    ->join("productos AS p", "p.id", "carrito.id_producto")
                                    ->where("carrito.email", $email)->get();
                // ? inserta los productos comprados
                foreach ($compras_productos AS $item) {
                    $state_oferta = 0;
                    // $precio_original = Productos::select("p_venta")->where("id", $item->id_producto)->get()->first()->p_venta;
                    $precio_original = $compras_productos->first()->p_venta;
                    $precio_final = $precio_original;
                    $title_oferta = "no";
                    if($item->oferta == true){
                        if($controller->state_oferta($item->id) == true){
                            $state_oferta = 1;
                            $precio_final = $controller->value_oferta($item->id);
                            $title_oferta = strtolower($controller->get_title_oferta($item->id));
                        }else{
                            $state_oferta = 0;
                            $precio_final = $precio_original;
                        }
                    }else{
                        $state_oferta = 0;
                        $precio_final = $precio_original;
                    }

                    ComprasProductos::insert([
                        "id_compra" => $id_compra,
                        "id_producto" => $item->id,
                        "cantidad" => $item->cantidad,
                        "p_original" => $precio_original,
                        "oferta" => $state_oferta,
                        "title_oferta" => $title_oferta,
                        "p_venta" => $precio_final
                    ]);
                }


                    // ? se debe enviar el correo
                    $correo = new ComprobanteCompra($id_compra);

                    $emails_admin = $this->get_emails_admins();

                    Mail::to($email)->send($correo);



                    // ? enviar a los responsables
                    foreach($emails_admin AS $item){
                        Mail::bcc($item->email)->send($correo);
                        sleep(3);
                    }

                    // ? eliminar el carrito enviado
                    Carrito::where("email", $email)->delete();
                    return redirect("./pgo-tbk".'/'.base64_encode($id_order));
                }else{
                    return redirect("./pgo-result");

                }
        } catch (\Throwable $th) {
            return redirect("./pgo-result");
        }


    }


    function get_emails_admins()
    {
        return ConfiguracionEmail::select("email")->where("estado", 1)->get();
    }

}

 //  tarjeta de debit aprobadad
    // 4051884239937763
// tarjeta de creidto
//     4051885600446623
// CVV 123

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
