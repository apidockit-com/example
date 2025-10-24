<?php declare(strict_types=1);

namespace App\Http\Order;

use App\DataTransferObject\OrderDto;
use App\Models\Order;
use IsmayilDev\ApiDocKit\Attributes\Resources\ApiEndpoint;
use IsmayilDev\ApiDocKit\Http\Responses\ApiResponse;
use IsmayilDev\ApiDocKit\Http\Responses\Contracts\PaginatedResponse;


class OrderListController
{
    #[ApiEndpoint(entity: Order::class)]
    public function __invoke(): PaginatedResponse
    {
        $orders = Order::query()->paginate(15)->map(function (Order $order) {
            return OrderDto::fromModel($order);
        });

        return ApiResponse::paginated($orders);
    }
}
