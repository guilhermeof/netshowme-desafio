<?php

namespace App\Http\Requests;

class ContactRequest extends BaseRequest
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
            'name' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|string',
            'message' => 'required|max:255',
            'attachment' => 'required|file|max:500|mimes:pdf,doc,docx,odt,txt',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser válido.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'message.required' => 'O campo mensagem é obrigatório.',
            'attachment.required' => 'O arquivo arquivo é obrigatório.',
            'attachment.mimes' => 'O arquivo deve ser de alguns dos tipos: pdf, doc, docx, odt ou txt.',
            'attachment.max' => 'O arquivo anexo não pode ser maior que 500kb.'
        ];
    }
}
