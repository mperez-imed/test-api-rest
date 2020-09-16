<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
    public function rules()
    {
        return [
            "rut" => "max:12|min:10|required",
            "name" => "max:50|required",
            "email" => "max:50|required|email",
            "phone" => "max:11|required",
        ];
    }

    public function attributes()
    {
        return [
            'rut' => 'Rut',
            'name' => 'Nombre',
            'email' => 'Correo Electrónico',
            'phone' => 'Teléfono',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["status" => 400, "message" => $validator->errors()->first()], 400));
    }
}
