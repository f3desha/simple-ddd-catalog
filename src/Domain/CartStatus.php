<?php declare(strict_types=1);

namespace App\Domain;

enum CartStatus: string {
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';

    public function isFinal(): bool
    {
        return match ($this) {
            self::PAID, self::CANCELED, self::COMPLETED => true,
            default => false,
        };
    }

    public static function default(): self
    {
        return self::DRAFT;
    }
}
