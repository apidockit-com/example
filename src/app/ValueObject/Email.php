<?php declare(strict_types=1);

namespace App\ValueObject;

use IsmayilDev\ApiDocKit\Attributes\Schema\DataSchema;

#[DataSchema]
readonly class Email
{
    public function __construct(private string $value)
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(__('exceptions.invalid_email', ['value' => $email]));
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
