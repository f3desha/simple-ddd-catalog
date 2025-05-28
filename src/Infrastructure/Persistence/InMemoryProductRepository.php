<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Link;
use App\Domain\Money;
use App\Domain\Product;
use App\Domain\ProductId;
use App\Domain\Repository\ProductRepository;

final class InMemoryProductRepository implements ProductRepository {
    private array $products = [];

    /**
     * @param Product[] $products
     */
    public function __construct(array $products = []) {
        foreach ($products as $raw) {
            $id = ProductId::generate();
            $this->products[] = new Product(
                $id,
                $raw['name'],
                $raw['desc'],
                new Link($raw['img']),
                new Money($raw['price'])
            );
        }
    }

    public function save(Product $product): void {
        $this->products[$product->id()->value()] = $product;
    }

    public function remove(ProductId $id): void {
        unset($this->products[$id->value()]);
    }

    public function getById(ProductId $id): ?Product {
        return $this->products[$id->value()] ?? null;
    }

    /**
     * @return Product[]
     */
    public function findAll(): array {
        return $this->products;
    }

}