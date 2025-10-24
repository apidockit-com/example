<?php declare(strict_types=1);

namespace App\Enum;

use IsmayilDev\ApiDocKit\Attributes\Schema\Enum;

#[Enum]
enum OrderPaymentStatus: int
{
    case Pending = 0;
    case Paid = 1;
    case Refunded = 2;
    case Cancelled = 3;
}
