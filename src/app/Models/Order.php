<?php

namespace App\Models;

use App\Enum\OrderPaymentStatus;
use App\Enum\OrderStatus;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property string|null $description
 * @property OrderStatus $status
 * @property OrderPaymentStatus $payment_status
 * @property int $total
 * @property array $tags
 * @property Carbon $placed_at
 * @property Carbon|null $paid_at
 * @property-read Collection<OrderItem> $items
 *
 * @method static OrderFactory factory()
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'status',
        'payment_status',
        'total',
        'tags',
        'placed_at',
        'paid_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'status' => OrderStatus::class,
        'payment_status' => OrderPaymentStatus::class,
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
