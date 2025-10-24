<?php declare(strict_types=1);

namespace App\DataTransferObject;

use App\Models\OrderItem;
use Illuminate\Contracts\Support\Arrayable;
use IsmayilDev\ApiDocKit\Attributes\Schema\DataSchema;

#[DataSchema]
readonly class OrderItemDto implements Arrayable
{
    public function __construct(
        public int $id,
        public int $orderId,
        public string $name,
        public int $quantity,
        public float $unitPrice,
        public float $total,
        public ?string $note,
    ) {
    }

    public static function fromModel(OrderItem $orderItem): self
    {
        return new self(
            id: $orderItem->id,
            orderId: $orderItem->order_id,
            name: $orderItem->name,
            quantity: $orderItem->quantity,
            unitPrice: $orderItem->unit_price,
            total: $orderItem->total,
            note: $orderItem->note,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'orderId' => $this->orderId,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'unitPrice' => $this->unitPrice,
            'total' => $this->total,
            'note' => $this->note,
        ];
    }
}
