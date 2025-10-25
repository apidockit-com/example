<?php declare(strict_types=1);

namespace App\OpenApi\Schemas;

use IsmayilDev\ApiDocKit\Enums\OpenApiPropertyType;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

class CustomSuccessResponse extends MediaType
{
    public function __construct(string $ref)
    {
        parent::__construct(
            mediaType: 'application/json',
            schema: new Schema(
                required: ['data', 'messages'],
                properties: [
                    new Property(property: 'data', type: OpenApiPropertyType::ARRAY->value, items: new Items(ref: $ref)),
                    new Property(property: 'messages', type: OpenApiPropertyType::ARRAY->value, items: new Items(type: 'string')),
                ],
                type: OpenApiPropertyType::OBJECT->value,
            )
        );
    }
}
