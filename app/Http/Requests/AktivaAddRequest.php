<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AktivaAddRequest extends FormRequest
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
            //
            'kode_aktiva' => 'required',
            'nama_aktiva' => 'required',
            'tanggal_perolehan' => 'required',
            'harga_perolehan' => 'required|min:0',
            'kategori' => 'required',
            'umur_ekonomis' => 'required',
        ];
    }
}
