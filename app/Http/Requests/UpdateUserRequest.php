<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            "rut" => "max:12|min:10|required|unique:users,rut," . $request->get("id"),
            "name" => "max:50|required",
            "email" => "max:50|required|email|unique:users,email," . $request->get("id"),
            "phone" => "max:11|required",
        ];
    }

    public function attributes()
    {
        return [
            'rut' => 'Rut',
            'name' => 'Nombre',
            'email' => 'Correo Electrónico',
            'phoen' => 'Teléfono',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["status" => 400, "message" => $validator->errors()->first()], 400));
    }
}
