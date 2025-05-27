<?php declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final readonly class Link {
    public function __construct(
        private string $value
    ) {
        if (!$this->isValidUrl($value)) {
            throw new InvalidArgumentException('Invalid URL format');
        }
    }

    public function value(): string {
        return $this->value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function isValidUrl(string $url): bool
    {
        return (bool)filter_var($url, FILTER_VALIDATE_URL);
    }
}