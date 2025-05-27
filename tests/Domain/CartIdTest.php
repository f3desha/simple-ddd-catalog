<?php declare(strict_types=1);

namespace App\Tests\Domain;


use App\Domain\CartId;

final class CartIdTest extends UuidValueObjectContractTest {

    protected function generateVO(): object {
        return CartId::generate();
    }

    protected function fromString(string $value): object {
        return CartId::fromString($value);
    }

    protected function valueObjectClass(): string {
        return CartId::class;
    }
}