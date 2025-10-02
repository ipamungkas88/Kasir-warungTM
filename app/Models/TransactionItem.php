<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'menu_id',
        'menu_name',
        'menu_price',
        'quantity',
        'subtotal',
        'notes'
    ];

    protected $casts = [
        'menu_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
