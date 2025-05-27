<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Link;
use App\Domain\Money;
use App\Domain\Product;
use App\Domain\ProductId;
use App\Domain\Repository\ProductRepository;
use PHPUnit\Framework\TestCase;

abstract class AbstractProductRepositoryTest extends TestCase {
    private ProductRepository $repository;
    abstract public function createRepository(): ProductRepository;

    protected function setUp(): void {
        $this->repository = $this->createRepository();
    }

    public function testItSavesAndFindsProduct(): void {
        $productId = ProductId::generate();
        $this->repository->save(new Product(
            $productId,
            'Smartphone X',
            'Latest smartphone with advanced features and high-resolution camera.',
            new Link('https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=300&h=200&fit=crop'),
            new Money(599.99)
        ));
        $product = $this->repository->getById($productId);
        $this->assertNotNull($product);
        $this->assertInstanceOf(Product::class, $product);
    }

    public function testItReturnsAllProducts(): void {
        $this->repository->save(new Product(
            ProductId::generate(),
            'Smartphone X',
            'Latest smartphone with advanced features and high-resolution camera.',
            new Link('https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=300&h=200&fit=crop'),
            new Money(599.99)
        ));
        $this->repository->save(new Product(
            ProductId::generate(),
            'Wireless Headphones',
            'Premium noise-cancelling headphones with long battery life.',
            new Link('https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=200&fit=crop'),
            new Money(149.99)
        ));

        $products = $this->repository->findAll();
        $this->assertCount(2, $products);
    }

    public function testItRemovesProduct(): void {
        $productId = ProductId::generate();
        $this->repository->save(new Product(
            $productId,
            'Smartphone X',
            'Latest smartphone with advanced features and high-resolution camera.',
            new Link('https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=300&h=200&fit=crop'),
            new Money(599.99)
        ));
        $product = $this->repository->getById($productId);
        $this->assertNotNull($product);
        $this->assertInstanceOf(Product::class, $product);

        $this->repository->remove($productId);
        $product = $this->repository->getById($productId);
        $this->assertNull($product);
    }

}