<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Transaction;
use Midtrans\Transaction as MidtransTransaction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // User.php
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

   
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function purchasedProducts()
    {
        $products = [];
        foreach ($this->transactions as $transaction) {
            $products = array_merge($products, $transaction->products);
        }
        return collect($products);
    }



    public function reviewableProductsCount()
    {
        $purchasedProducts = $this->purchasedProducts();

        $productsToReview = $purchasedProducts->filter(function ($product) {
            return !Review::where('produk_id', $product['id'])
                ->where('user_id', $this->id)
                ->exists();
        });

        return $productsToReview->count();
    }
}
