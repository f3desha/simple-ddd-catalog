<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\ProductId;

final class ProductIdTest extends UuidValueObjectContractTest {

    protected function generateVO(): object {
        return ProductId::generate();
    }

    protected function fromString(string $value): object {
        return ProductId::fromString($value);
    }

    protected function valueObjectClass(): string {
        return ProductId::class;
    }
}