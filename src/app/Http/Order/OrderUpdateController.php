<?php declare(strict_types=1);

namespace App\Http\Order;

use App\DataTransferObject\OrderDto;
use App\Http\Order\Requests\OrderUpdateRequest;
use App\Models\Order;
use IsmayilDev\ApiDocKit\Attributes\Resources\ApiEndpoint;
use IsmayilDev\ApiDocKit\Http\Responses\ApiResponse;
use IsmayilDev\ApiDocKit\Http\Responses\Contracts\SingleResourceResponse;

class OrderUpdateController
{
    #[ApiEndpoint(entity: Order::class)]
    public function __invoke(int $id, OrderUpdateRequest $request): SingleResourceResponse
    {
        $order = Order::query()->findOrFail($id);
        $order->update($request->validated());
        $order->refresh();

        return ApiResponse::resource(OrderDto::fromModel($order));
    }
}
