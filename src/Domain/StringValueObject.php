<?php declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

abstract readonly class StringValueObject {
    protected function __construct(
        protected string $value
    ) {}

    public function __toString(): string {
        return $this->value;
    }

    public function value(): string {
        return $this->value;
    }

    public function equals(self $other): bool {
        return static::class === get_class($other) && $this->value === $other->value;
    }

}