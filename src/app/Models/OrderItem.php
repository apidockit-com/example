<?php

namespace App\Models;

use Database\Factories\OrderItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property-read int $id
 * @property-read int $order_id
 * @property string $name
 * @property int $quantity
 * @property float $unit_price
 * @property float $total
 * @property string|null $note
 * @property-read Order $order
 *
 * @method static OrderItemFactory factory()
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'quantity',
        'unit_price',
        'total',
        'note',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
