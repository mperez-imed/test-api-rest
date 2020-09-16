<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Rest\ApiRest;
use App\Soap\SoapService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $response = SoapService::validate($request->get("rut"), $request->get("email"));
        if ($response->status != 200) {
            return response()->json(["status" => $response->status, "message" => $response->message], $response->status);
        }
        try {
            $user = new User();
            $user->rut = $request->get("rut");
            $user->name = $request->get("name");
            $user->email = $request->get("email");
            $user->phone = $request->get("phone");
            $user->confirmed = 0;
            $user->save();

            $url = URL::to('/');
            $token = base64_encode($user->email);
            $toEmail = $user->email;
            $toName = $user->name;

            $data = array(
                "link" => "$url/user/validate/$token",
            );

            \Mail::send('mail.register', $data, function ($message) use ($toName, $toEmail) {
                $message->to($toEmail, $toName)
                    ->subject("Nuevo registro");
                $message->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'));
            });

            return response()->json(["status" => 200, "message" => "Proceso finalizado"], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(["status" => 500, "message" => "No se pudo realizar la acción"], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user = new User();
            $user->rut = $request->get("rut");
            $user->name = $request->get("name");
            $user->email = $request->get("email");
            $user->phone = $request->get("phone");
            $user->save();
            return response()->json(["status" => 200, "message" => "Proceso finalizado"], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(["status" => 500, "message" => "No se pudo realizar la acción"], 500);
        }
    }

    public function confirm(ConfirmUserRequest $request)
    {
        try {
            $user = User::where("email", "=", $request->get("email"))
                ->first();

            if (empty($user)) {
                return response()->json(["status" => 400, "message" => "Usuario no encontrado"], 400);
            }

            if ($user->confirmed) {
                return response()->json(["status" => 400, "message" => "El usuario ya confirmo su correo"], 400);
            }

            $user->confirmed = 1;
            $user->save();

            return response()->json(["status" => 200, "message" => "Proceso finalizado"], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(["status" => 500, "message" => "No se pudo realizar la acción"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(["status" => 200, "message" => "Proceso finalizado"], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(["status" => 500, "message" => "No se pudo realizar la acción"], 500);
        }
    }

    public function canConfirm($token)
    {
        $email = base64_decode($token);

        $message = "Error al confirmar el usuario";

        $data = array();
        $data["email"] = $email;
        $response = ApiRest::request('PUT', 'users/validate/confirm', $data);

        if ($response->status == 200) {
            $soapResponse = SoapService::confirm($email);
            if ($soapResponse->status == 200) {
                $message = "Usuario confirmado";
            }
        } else {
            $message = $response->message;
        }
        return view('user.finished')
            ->with("message", $message);
    }
}
