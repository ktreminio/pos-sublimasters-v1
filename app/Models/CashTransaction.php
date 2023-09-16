<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cash_transaction';
    protected $fillable = [
        'date',
        'amount',
        'comment',
        'type_transaction',
        'id_cash_register',
        'id_expense',
        'id_income'
    ];

    // Relacion uno a muchos inversa
    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class, 'id_cash_register');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_income');
    }
}
