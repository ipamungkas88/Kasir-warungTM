<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'is_available',
        'image_url',
        'stock'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
