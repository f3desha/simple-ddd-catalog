<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Link;
use App\Domain\Money;
use App\Domain\Product;
use App\Domain\ProductId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase {
    public function testItCreatesProductWithValidData(): void {
        $id = ProductId::generate();
        $product = new Product($id, 'Test Product', 'Valid description',
            new Link('https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300&h=200&fit=crop'), new Money(199.99));

        $this->assertSame($id, $product->id());
        $this->assertSame('Test Product', $product->name());
        $this->assertSame('Valid description', $product->description());
        $this->assertSame('https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300&h=200&fit=crop', $product->image()->value());
        $this->assertSame(199.99, $product->price()->amount());
    }

    public function testProductInitializationWithEmptyNameCausesInvalidArgumentException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Product name cannot be empty');

        $id = ProductId::generate();
        new Product($id, '', 'Valid description',
            new Link('https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300&h=200&fit=crop'), new Money(199.99));
    }

    public function testProductInitializationWithNegativePriceCausesInvalidArgumentException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount cannot be less than 0');

        $id = ProductId::generate();
        new Product($id, 'Test Title', 'Valid description',
            new Link('https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300&h=200&fit=crop'), new Money(-199.99));
    }

    public function testProductCantHaveTooLongTitle(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Product name cannot be longer then 255 symbols long');

        $id = ProductId::generate();
        $longName = str_repeat('A', 256);
        new Product($id, $longName, 'Valid description',
            new Link('https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300&h=200&fit=crop'), new Money(199.99));
    }

    public function testProductCantHaveTooLongDescription(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Product description cannot be longer then 1000 symbols long');

        $id = ProductId::generate();
        $longDescription = str_repeat('A', 1001);
        new Product($id, "Product name", $longDescription,
            new Link('https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300&h=200&fit=crop'), new Money(199.99));
    }

    public function testProductImageInvalidLinkCausesException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URL format');

        $id = ProductId::generate();
        new Product($id, 'Test Title', 'Valid description',
            new Link('INVALID_IMAGE_LINK'), new Money(22.3));
    }

    public function testProductCantHaveZeroPrice(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Product price cannot be zero');

        $id = ProductId::generate();
        new Product($id, 'Test Title', 'Valid description',
            new Link('https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300&h=200&fit=crop'), new Money(0));
    }

}