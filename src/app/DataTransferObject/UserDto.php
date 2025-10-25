<?php declare(strict_types=1);

namespace App\DataTransferObject;

use App\Models\User;
use App\ValueObject\Email;
use Illuminate\Contracts\Support\Arrayable;
use IsmayilDev\ApiDocKit\Attributes\Schema\DataSchema;

#[DataSchema]
class UserDto implements Arrayable
{
    public function __construct(
        public int $id,
        public string $name,
//        public Email $email,
    ) {
    }

    public static function fromModel(User $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
//            email: new Email($model->email),
        );
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
//            'email' => $this->email->getValue(),
        ];
    }
}
