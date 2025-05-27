<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Money;
use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase {
    public function testItCanBeCreatedFromString(): void {
        $money = Money::fromString('199.99');
        $this->assertEquals(199.99, $money->amount());
    }

    public function testItCanBeComparedWithOtherSelfInstance(): void
    {
        $object = new Money(199.99);
        $other = new Money(199.99);
        $this->assertTrue($object->equals($other));
    }

    public function testItCanBeParsedAsString(): void {
        $object = new Money(199.99);
        $this->assertIsString((string)$object);
    }

}