<?php declare(strict_types=1);

namespace App\Http\Order\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    public function rules(): array
    {


        return [
            'status' => 'sometimes|string',
            'paymentStatus' => 'sometimes|string',
            'tags' => 'sometimes|array',
            'tags.*' => 'string',
            'placedAt' => 'sometimes|date',
            'paidAt' => 'sometimes|date',
        ];


    }
}
