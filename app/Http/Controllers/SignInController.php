<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginUser;
use App\Http\Controllers\PasswordController;
use App\Mail\MailActivateRegister;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;


class SignInController extends Controller
{

    // * crea una nueva cuenta para login
    /**
     * funcion que registra un usauario o lo logea, en caso de registro normal manda un email para su activacion
     *
     * @param integer $id_plataforma pallataforma web o mobil
     * @param integer $id_rss si se registro en google o facebook normal
     * @param string $email Descripción del segundo parámetro.
     * @param string $password Descripción del segundo parámetro.
     * @param string $nombre Descripción del segundo parámetro.
     * @param string $pass Descripción del segundo parámetro.
     * @return string img del valor de retorno.
     */
    function create_sign_in(Request $request)
    {
        $id_plataforma = $request->id_plataforma; // ? 1 -> web 2-> mobil
        $id_rss = $request->tipo_rss; // ? 1-> google 2-> facebook 0-> nomarl 
        $estado = $id_rss == 0 ? 0 : 1;
        $email = strtolower($request->email);
        $password = trim($request->password);
        $nombre = strtolower($request->name);
        $pass = $request->tipo_rss == 0 ? $this->generatePassword($request->password): null; // ? => si es de facebook o gmail no tiene password
        // $img = $id_rss == 0 ? urlImg() : $request->img_url;
        $img = $request->img_url;

        $existingUser = LoginUser::where('email', $email)->first();
        $fechaActual = Carbon::now();
       
        // ? si no existe el usuario
        if (!$existingUser) {
            // El usuario no existe, puedes crear uno nuevo
            $register = new LoginUser();
            $register->id_plataforma = $id_plataforma;
            $register->tipo_rrss = $id_rss;
            $register->estado = $estado;
            $register->email = $email;
            $register->nombre = $nombre;
            $register->img = $img;
            $register->password = $pass;
            $register->save();
            // ? se debe enviar el correo y el correo debe verificar si esta pasado lso 5 minutos
            // ? y solo si perteneces a el registro normal
            if($id_rss == 0){
                $id_registro = base64_encode($register->id);
    
                $correo = new MailActivateRegister($id_registro);
                Mail::to($email)->send($correo);
            }
            // ? si es usuario de redes sociales
            if($id_rss != 0){
                $data = [
                    'response'=>'success',
                    'data' => [
                        'id_user' => $existingUser->id,
                        'nombre' => $existingUser->nombre,
                        'img' => $existingUser->img
                    ]                           
                ];
                return response()->json($data);
            }
            return $data = [
                'response'=>'sending',
                'data' => null                          
            ];
        } else {
            // ? el usuario existe, pero no tiene password
            if($id_rss == 0){
                $data = [
                    'response'=>'existe',
                    'data' => null                          
                ];
                return response()->json($data);
            }
            // ? si inicia con una SSRR
            if($id_rss != 0){
                $data = [
                    'response'=>'success',
                    'data' => [
                        'id_user' => $existingUser->id,
                        'nombre' => $existingUser->nombre,
                        'img' => $existingUser->img
                    ]                           
                ];
                return response()->json($data);
            }
        }
    }


    function generatePassword($password)
    {   
        $controll = new PasswordController($password);
        $key = $controll->generatePassword();
        return $key;
    }

    function activate_register($id_registro)
    {
        $id_registro = base64_decode($id_registro);

        $data = LoginUser::select("estado","updated_at")->where("id", $id_registro)->first();

        $fechaActual = carbon::now();

        if($data->estado == 0){
            if ($data->updated_at->diffInMinutes($fechaActual) <= 5) {
                LoginUser::where("id", $id_registro)->update(["estado" => 1]);
                // return "ok";/
                return redirect('https://neuamtruck.cl');
            } 
            return redirect('https://neuamtruck.cl');
        }
        return redirect('https://neumatruck.cl');
    }


    function start_session_login(Request $request)
    {
        $user = strtolower($request->user);
        $pass = trim($request->pass);
        try {
            $data = LoginUser::select("id", "nombre", "estado", "img", "password")->where("email", $user)->get();
            if($data->count() >0){
                if($data->first()->estado == 1){
                    if(password_verify($pass, $data->first()->password)){
                        $data = [
                                'response'=>'success',
                                'data' => [
                                    'id_user' => $data->first()->id,
                                    'nombre' => $data->first()->nombre,
                                    'img' => $data->first()->img
                                ]                           
                            ];
                            return response()->json($data);
                        }else{
                            return response()->json(
                                [
                                    'response' => "error-password",
                                    'data' => []
                                ]
                            );
                        }
                }else{
                    return response()->json(
                        [
                            'response' => "not-activate",
                            'data' => []
                        ]
                    );
                }
            }else{
                return reponse()->json(
                    [
                        'response' => "error-not-user",
                        'data' => null
                    ]
                );
            }
        } catch (\Throwable $th) {
            return "error";
        }
    }




}
