<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Relasi ke model Product
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relasi ke model user
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id'); // Relasi ke model Product
    }
}
