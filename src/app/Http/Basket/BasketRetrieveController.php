<?php declare(strict_types=1);

namespace App\Http\Basket;

use App\DataTransferObject\BasketDto;
use App\OpenApi\Schemas\CustomSuccessResponse;
use IsmayilDev\ApiDocKit\Attributes\Resources\ApiEndpoint;
use IsmayilDev\ApiDocKit\Attributes\Responses\ErrorResponses;
use IsmayilDev\ApiDocKit\Http\Responses\ApiResponse;
use IsmayilDev\ApiDocKit\Http\Responses\Contracts\CollectionResponse;

class BasketRetrieveController
{
    #[ApiEndpoint(
        entity: 'Basket',
        errorResponses: new ErrorResponses(only: [403]),
        successResponseSchema: CustomSuccessResponse::class,
    )]
    public function __invoke(): CollectionResponse
    {
        $sample1 = new BasketDto(id: 1, userId: 1, productId: 1, quantity: 2, price: 10.5);
        $sample2 = new BasketDto(id: 2, userId: 1, productId: 2, quantity: 3, price: 20.5);

        return ApiResponse::collection([
            'data'=> [$sample1, $sample2],
            'messages' => ['Successfully retrieved baskets'],
        ]);
    }
}
