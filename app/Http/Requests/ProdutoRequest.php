<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $messages = [
            'nome.required' => 'Digite o nome do produto',
            'codigo.required' => 'Digite o código do produto',
            'codigo.unique' => 'Código Zotti ' . $this->request->get('codigo') . ' já foi cadastrado',
            'unidade_estoque.required' => 'Digite a unidade em estoque',
            'prateleira.required' => 'Digite a prateleira do produto',
            'gaveta.required' => 'Digite a gaveta do produto',
            'natureza_operacao.required' => 'Digite a natureza de operação',
            'ncm.required' => 'Digite o NCM',
            'origem.required' => 'Digite a origem',
            'cest.required' => 'Digite o Cest'
        ];

        if(count($this->request->get('precos'))>0) {
            foreach ($this->request->get('precos') as $key => $val) {
                $messages['precos.'.$key.'.lista_id.required'] = $key+1 . 'º item da lista de preço não possui uma lista definida';
            }
        }
        return $messages;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nome' => 'required',
            'codigo' => [
                'required',
                Rule::unique('produtos')->ignore($this->request->get('id'))
            ],
            'unidade_estoque' => 'required',
            'prateleira' => 'required',
            'gaveta' => 'required',
            'natureza_operacao' => 'required',
            'ncm' => 'required',
            'origem' => 'required',
            'cest' => 'required'
        ];

        if(count($this->request->get('precos'))>0) {
            foreach ($this->request->get('precos') as $key => $val) {
                $rules['precos.'.$key.'.lista_id'] = 'required';
            }
        }
        return $rules;
    }
}
