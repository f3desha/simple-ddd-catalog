<?php declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final class Money {

    public function __construct(
        private float $amount,
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException("Amount cannot be less than 0");
        }
    }

    public function amount(): float {
        return $this->amount;
    }

    public static function fromString(string $value): self
    {
        return new self((float)$value);
    }

    public function equals(self $other): bool
    {
        return $this->amount === $other->amount;
    }

    public function __toString(): string
    {
        return (string)$this->amount;
    }
}