<?php declare(strict_types=1);

namespace App\DataTransferObject;

use App\Enum\OrderPaymentStatus;
use App\Enum\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use IsmayilDev\ApiDocKit\Attributes\Properties\ArrayOf;
use IsmayilDev\ApiDocKit\Attributes\Schema\DataSchema;

#[DataSchema]
readonly class OrderDto implements Arrayable
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $description,
        public OrderStatus $status,
        public OrderPaymentStatus $paymentStatus,
        public int $total,

        public Carbon $placedAt,
        public ?Carbon $paidAt,
        #[ArrayOf(OrderItemDto::class)]
        public Collection $items,
    ) {
    }

    public static function fromModel(Order $order): self
    {
        return new self(
            id: $order->id,
            userId: $order->user_id,
            description: $order->description,
            status: $order->status,
            paymentStatus: $order->payment_status,
            total: $order->total,
            placedAt: $order->placed_at,
            paidAt: $order->paid_at,
            items: $order->items,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'description' => $this->description,
            'status' => $this->status,
            'paymentStatus' => $this->paymentStatus->value,
            'total' => $this->total,
            'placedAt' => $this->placedAt->toDateTimeString(),
            'paidAt' => $this->paidAt?->format('Y-m-d'),
            'items' => $this->items->map(fn (OrderItem $item) => OrderItemDto::fromModel($item)),
        ];
    }
}
