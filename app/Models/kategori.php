<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
    ];

    public function produk()
    {
        return $this->belongsTo(produk::class);
    }
    public function getRouteKeyName()
    {
        return 'slug'; // Menentukan bahwa Eloquent harus menggunakan slug untuk route model binding
    }
}
