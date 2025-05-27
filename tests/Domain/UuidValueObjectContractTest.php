<?php declare(strict_types=1);

namespace App\Tests\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

abstract class UuidValueObjectContractTest extends TestCase {
    protected object $vo;

    abstract protected function generateVO(): object;
    abstract protected function fromString(string $value): object;
    abstract protected function valueObjectClass(): string;


    protected function setUp(): void
    {
        $this->vo = $this->generateVO();
    }

    public function testItHasStringId(): void
    {
        $this->assertIsString((string)$this->vo);
    }

    public function testIdIsUuid4Valid(): void
    {
        $this->assertTrue(Uuid::isValid((string)$this->vo));
    }

    public function testValueIsString(): void
    {
        $this->assertIsString($this->vo->value());
    }

    public function testItDoesNotEqualAnotherInstanceWithDifferentValue(): void
    {
        $other = $this->generateVO();
        $this->assertFalse($this->vo->equals($other));
    }

    public function testItCanBeComparedWithOtherSelfInstance(): void
    {
        $class = $this->valueObjectClass();
        $other = $this->fromString((string)$this->vo);
        $this->assertTrue($this->vo->equals($other));
    }

    public function testCanBeCreatedFromValidUuidString(): void
    {
        $uuid = (string)$this->vo;
        $other = $this->fromString($uuid);
        $this->assertTrue(Uuid::isValid((string)$other));
        $this->assertEquals($uuid, (string)$other);
    }

    public function testItCantBeCreatedFromValidUuid4String(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid UUID format');

        $this->fromString('INVALID_STRING');
    }
}