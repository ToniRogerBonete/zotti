<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
            'nome.required' => 'Digite o nome do produto',
            'codigo.required' => 'Digite o código do produto',
            'unidade_estoque.required' => 'Digite a unidade em estoque',
            'prateleira.required' => 'Digite a prateleira do produto',
            'gaveta.required' => 'Digite a gaveta do produto',
            'natureza_operacao.required' => 'Digite a natureza de operação',
            'ncm.required' => 'Digite o NCM',
            'origem.required' => 'Digite a origem',
            'cest.required' => 'Digite o Cest'
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
            'nome' => 'required',
            'codigo' => 'required',
            'unidade_estoque' => 'required',
            'prateleira' => 'required',
            'gaveta' => 'required',
            'natureza_operacao' => 'required',
            'ncm' => 'required',
            'origem' => 'required',
            'cest' => 'required'
        ];
    }
}
