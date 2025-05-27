<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\CartItem;
use App\Domain\Money;
use App\Domain\ProductId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CartItemTest extends TestCase {
    public function testItCreatesCartItemWithValidData(): void {
        $productId = ProductId::generate();
        $cartItem = new CartItem($productId, 1, new Money(15.99));

        $this->assertSame($productId, $cartItem->productId());
        $this->assertSame(1, $cartItem->quantity());
        $this->assertSame(15.99, $cartItem->priceAtAdd()->amount());
    }

    public function testQuantityLessThenOneThrowsException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity must be at least 1');

        new CartItem(ProductId::generate(), 0, new Money(15.99));
    }

}