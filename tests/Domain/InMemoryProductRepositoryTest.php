<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Repository\ProductRepository;
use App\Infrastructure\Persistence\InMemoryProductRepository;

final class InMemoryProductRepositoryTest extends AbstractProductRepositoryTest {
    public function createRepository(): ProductRepository {
        return new InMemoryProductRepository([]);
    }

}