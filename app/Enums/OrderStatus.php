<?php
namespace App\Enums;

enum OrderStatus: string {
    case NEW_ORDER = 'NEW_ORDER';
    case IN_PROGRESS = 'IN_PROGRESS';
    case DELIVERED = 'DELIVERED';
    case CANCELED = 'CANCELED';
}
