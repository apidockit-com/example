<?php declare(strict_types=1);

namespace App\DataTransferObject;

use Illuminate\Contracts\Support\Arrayable;
use IsmayilDev\ApiDocKit\Attributes\Properties\NumberProperty;
use IsmayilDev\ApiDocKit\Attributes\Schema\DataSchema;

#[DataSchema(properties: [
    new NumberProperty(description: 'Total value of basket item', property: 'total', example: 43.45),
])]
readonly class BasketDto implements Arrayable
{
    public function __construct(
        public int $id,
        public int $userId,
        public int $productId,
        public int $quantity,
        public float $price,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'productId' => $this->productId,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->price * $this->quantity,
        ];
    }
}
