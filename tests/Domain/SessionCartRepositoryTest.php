<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Repository\CartRepository;
use App\Infrastructure\Persistence\SessionCartRepository;

final class SessionCartRepositoryTest extends AbstractCartRepositoryTest {
    public function createRepository(): CartRepository {
        return new SessionCartRepository();
    }

    protected function tearDown(): void {
        $_SESSION = [];
    }

}