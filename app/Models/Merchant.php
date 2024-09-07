<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('company_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                ->orWhere('address', 'LIKE', "%{$searchTerm}%")
                ->orWhere('tag', 'LIKE', "%{$searchTerm}%");
        });
    }
}
