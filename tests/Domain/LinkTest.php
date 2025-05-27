<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Link;
use PHPUnit\Framework\TestCase;

final class LinkTest extends TestCase {
    public function testItCanBeCreatedFromString(): void {
        $link = Link::fromString('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=200&fit=crop');
        $this->assertEquals('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=200&fit=crop', $link->value());
    }

    public function testItCanBeComparedWithOtherSelfInstance(): void
    {
        $object = new Link('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=200&fit=crop');
        $other = new Link('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=200&fit=crop');
        $this->assertTrue($object->equals($other));
    }

    public function testItCanBeParsedAsString(): void {
        $object = new Link('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=200&fit=crop');
        $this->assertIsString((string)$object);
    }

}