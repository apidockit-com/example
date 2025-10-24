<?php declare(strict_types=1);

namespace App\Http\Order\Requests;

use App\Enum\OrderPaymentStatus;
use App\Enum\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId' => 'required|integer',
            'description' => 'string|nullable',
            'status' => ['required', Rule::enum(OrderStatus::class)],
            'paymentStatus' => ['required', Rule::enum(OrderPaymentStatus::class)],
            'total' => 'required|integer|min:1',
            'tags' => 'required|array',
            'tags.*' => 'string',
            'paidAt' => 'nullable|date',
        ];
    }
}
