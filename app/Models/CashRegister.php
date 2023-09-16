<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;
    const UPDATED_AT = 'modified_at';
    protected $table = 'cash_register';
    protected $fillable = [
        'cash_according_to_system',
        'cash_according_to_user',
        'transfer_according_to_system',
        'transfer_according_to_user',
        'closing_amount',
        'difference',
        'closing_date',
        'closing_time',
        'comment',
        'opening_amount',
        'opening_date',
        'opening_time',
        'status',
        'is_closed',
        'created_by',
        'modified_by',
        'pasive'
    ];

    // Relacion uno a muchos
    public function cashTransactions()
    {
        return $this->hasMany(CashTransaction::class, 'id_cash_register');
    }
}
