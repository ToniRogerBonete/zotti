<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListaRequest extends FormRequest
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

    public function messages()
    {
        return [
            'descricao.required' => 'Digite a descrição',
            'contato.required' => 'Digite um contato',
            'telefone.required' => 'Digite o telefone',
            'observacao.required' => 'Digite a observcação',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'descricao' => 'required',
            'contato' => 'required',
            'telefone' => 'required',
            'observacao' => 'required'
        ];
    }
}
