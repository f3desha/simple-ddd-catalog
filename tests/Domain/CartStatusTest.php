<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\CartStatus;
use PHPUnit\Framework\TestCase;

final class CartStatusTest extends TestCase {
    public function testIsFinalReturnsTrueOnlyForFinalStatuses(): void
    {
        $this->assertFalse(CartStatus::DRAFT->isFinal(), 'DRAFT не должен считаться финальным');
        $this->assertFalse(CartStatus::PENDING->isFinal(), 'PENDING не должен считаться финальным');
        $this->assertTrue(CartStatus::PAID->isFinal(), 'PAID должен считаться финальным');
        $this->assertTrue(CartStatus::CANCELED->isFinal(), 'CANCELED должен считаться финальным');
        $this->assertTrue(CartStatus::COMPLETED->isFinal(), 'COMPLETED должен считаться финальным');
    }

    public function testDefaultReturnsDraft(): void
    {
        $this->assertSame(CartStatus::DRAFT, CartStatus::default());
    }

}