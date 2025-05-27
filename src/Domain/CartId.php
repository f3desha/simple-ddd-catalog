<?php declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final readonly class CartId extends StringValueObject {
    private function __construct(string $value)
    {
        if (!Uuid::isValid($value)) {
            throw new InvalidArgumentException('Invalid UUID format');
        }
        parent::__construct($value);
    }

    public static function generate(): self {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $value): self {
        return new self($value);
    }
}