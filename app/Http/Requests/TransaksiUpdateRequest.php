<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiUpdateRequest extends FormRequest
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
            'tanggal_transaksi' => 'required',
            'nama_transaksi' => 'required',
            'akun_debit_id' => 'required',
            'akun_kredit_id' => 'required',
            'jumlah_transaksi' => 'required',
        ];
    }
}
