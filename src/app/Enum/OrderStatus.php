<?php declare(strict_types=1);

namespace App\Enum;

use IsmayilDev\ApiDocKit\Attributes\Schema\Enum;

#[Enum]
enum OrderStatus: string
{
    case Pending = 'pending';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
    case Rejected = 'rejected';
    case Completed = 'completed';
}
