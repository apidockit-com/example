<?php declare(strict_types=1);

namespace App\Http\Order;

use App\DataTransferObject\OrderDto;
use App\Http\Order\Requests\OrderCreateRequest;
use App\Models\Order;
use IsmayilDev\ApiDocKit\Attributes\Resources\ApiEndpoint;
use IsmayilDev\ApiDocKit\Http\Responses\ApiResponse;
use IsmayilDev\ApiDocKit\Http\Responses\Contracts\CreatedResponse;

class OrderCreateController
{
    #[ApiEndpoint(entity: Order::class)]
    public function __invoke(OrderCreateRequest $request): CreatedResponse
    {
        $order = Order::query()->create($request->validated());

        return ApiResponse::created(OrderDto::fromModel($order));
    }
}
