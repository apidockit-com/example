<?php declare(strict_types=1);

namespace App\Http\Order;

use App\Models\Order;
use IsmayilDev\ApiDocKit\Attributes\Resources\ApiEndpoint;
use IsmayilDev\ApiDocKit\Http\Responses\ApiResponse;
use IsmayilDev\ApiDocKit\Http\Responses\Contracts\EmptyResponse;

class OrderDeleteController
{
    #[ApiEndpoint(entity: Order::class)]
    public function __invoke(int $id): EmptyResponse
    {
        Order::query()->findOrFail($id)->delete();

        return ApiResponse::empty();
    }
}
