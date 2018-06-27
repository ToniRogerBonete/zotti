<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
     * Determine as mensagens para Usuário.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'name.required'=>'Digite um nome',
            'name.min'=>'O nome deve conter no mínimo 5 caracteres',
            'name.max'=>'O nome deve conter no máximo 100 caracteres',
            'email.required'=>'Digite um e-mail',
            'email.unique'=>'O e-mail já está cadastrado no sistema',
            'email.email'=>'O e-mail não é válido',
            'password.required'=>'Digite uma senha',
            'password.min'=>'A senha deve conter no minimo 6 caracteres',
            'password.confirmed'=>'Senha não confirmada',
            'password_confirmation.required'=>'Confirme a senha',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name'=>'required|min:5|max:100',
        ];

        if($this->get('id')) {
            if($this->request->get('password')) {
                $rules['password'] = 'required|min:6|confirmed';
                $rules['password_confirmation'] = 'required';
            }
        } else {
            $rules['email'] = 'sometimes|required|unique:users|email';
            $rules['password'] = 'required|min:6|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        return $rules;
    }
}
