<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktiva extends Model
{
    use HasFactory;

    protected $table = 'aktiva';

    protected $fillable = ['kode_aktiva', 'nama_aktiva', 'jenis_aktiva', 'tanggal_perolehan', 'harga_perolehan', 'penyusutan_perhari'];
}
