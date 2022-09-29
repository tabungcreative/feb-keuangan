<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AkunUpdateSaldoRequest extends FormRequest
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
            'akun_id' => 'required',
            'update_type' => 'required',
            'saldo' => 'required|min:0'
        ];
    }
}
