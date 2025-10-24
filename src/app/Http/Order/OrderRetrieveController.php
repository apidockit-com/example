<?php declare(strict_types=1);

namespace App\Http\Order;

use App\DataTransferObject\OrderDto;
use App\Models\Order;
use IsmayilDev\ApiDocKit\Attributes\Resources\ApiEndpoint;
use IsmayilDev\ApiDocKit\Http\Responses\ApiResponse;
use IsmayilDev\ApiDocKit\Http\Responses\Contracts\SingleResourceResponse;

class OrderRetrieveController
{
    #[ApiEndpoint(entity: Order::class)]
    public function __invoke(int $id): SingleResourceResponse
    {
        $order = Order::query()->findOrFail($id);

        return ApiResponse::resource(OrderDto::fromModel($order));
    }
}
