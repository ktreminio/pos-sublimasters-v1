<?php
namespace App\Enums;

enum CashTransactionType: string {
    case INCOME = 'INCOME';
    case EXPENSE = 'EXPENSE';
    case SALE = 'SALE';
    case PURCHASE = 'PURCHASE';
}
