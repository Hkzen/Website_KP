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
        'harga',
        'stok',
        'excerpt',
        'deskripsi_produk',
        'foto_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id');
    }
        public function getRouteKeyName()
    {
        return 'slug'; // Menentukan bahwa Eloquent harus menggunakan slug untuk route model binding
    }

    public function decreaseStock($quantity)
    {
        $this->stok -= $quantity;
        $this->save();
    }
}
