<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = [
    'invoice_number',
    'user_id',
    'address',
    'postal_code',
    'total_price'
];
    public function items()
{
    return $this->hasMany(InvoiceItem::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
