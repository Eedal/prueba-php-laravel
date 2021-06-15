<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'cedula' => 'not_regex:/[a-zA-Z]/|required|unique:users,cedula,' . $this->route('user'),
            'correo' => 'required|email:rfc,dns|unique:users,correo,' . $this->route('user'),
            'telefono' => 'not_regex:/[a-zA-Z]/',
            'nombres' => 'required'
        ];
    } 

    public function messages()
    {
        return [
            'cedula.not_regex' => 'El campo cedula no puede contener letras',
            'cedula.required' => 'El campo cedula es requerido',
            'cedula.unique' => 'El campo cedula que estás escribiendo ya fue tomado',
            'correo.required' => 'El campo correo es requerido',
            'correo.email' => 'El campo correo debe tener un formato de correo electronico',
            'correo.unique' => 'El campo correo que estás escribiendo ya fue tomado',
            'telefono.not_regex' => 'El campo telefono no puede contener letras',
            'nombres.required' => 'El campo nombres es requerido',
        ];
    }

}
