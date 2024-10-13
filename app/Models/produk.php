<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'slug',
        'kategori_id',
        'stok',
        'excerpt',
        'deskripsi_produk',
        'foto_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class);
    }
    public function getRouteKeyName()
{
    return 'slug'; // Menentukan bahwa Eloquent harus menggunakan slug untuk route model binding
}

}
