<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case PENDING = 1;
    case PAID = 2;
    case FULFILLED = 3;
    case REFUND = 4;
    case PAYMENT_FAILED = 5;

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PAID => 'Paid',
            self::FULFILLED => 'Fulfilled',
            self::REFUND => 'Refund',
            self::PAYMENT_FAILED => 'Payment Failed',
        };
    }
}
