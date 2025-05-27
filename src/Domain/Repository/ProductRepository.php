<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Product;
use App\Domain\ProductId;

interface ProductRepository {
    public function save(Product $product): void;

    public function remove(ProductId $id): void;

    public function getById(ProductId $id): ?Product;

    public function findAll(): array;
}