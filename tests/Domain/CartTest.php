<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Cart;
use App\Domain\CartId;
use App\Domain\CartItem;
use App\Domain\CartStatus;
use App\Domain\Money;
use App\Domain\ProductId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CartTest extends TestCase {
    public function testItCreatesCartWithValidData(): void {
        $cartId = CartId::generate();
        $cartItems = [
            new CartItem(ProductId::generate(), 1, new Money(15.99))
        ];
        $cart = new Cart(
            $cartId,
            $cartItems,
        );

        $this->assertSame($cartId, $cart->id());
        $this->assertSame($cartItems, $cart->items());
        $this->assertSame(CartStatus::default(), $cart->status());
    }

    public function testNewProductCanBeAddedToCart(): void {
        $cart = new Cart(CartId::generate(), [
            new CartItem(ProductId::generate(), 1, new Money(15.99))
        ]);
        $this->assertCount(1, $cart->items());

        $cart->addItem(ProductId::generate(), 1, new Money(4.99));
        $this->assertCount(2, $cart->items());
    }

    public function testNotExistingProductCantBeFoundInCart(): void {
        $item = new CartItem(ProductId::generate(), 1, new Money(15.99));
        $cart = new Cart(CartId::generate(), [
            $item
        ]);

        $anotherItem = new CartItem(ProductId::generate(), 1, new Money(4.99));
        $this->assertNull($cart->findItem($anotherItem->productId()));
    }

    public function testExistingProductIncreaseQuantity(): void {
        $item = new CartItem(ProductId::generate(), 1, new Money(15.99));
        $cart = new Cart(CartId::generate(), [
            $item
        ]);
        $cart->addItem($item->productId(), 1, new Money(15.99));
        $updatedItem = $cart->findItem($item->productId());
        $this->assertSame(2, $updatedItem->quantity());
    }

    public function testAddingExistingProductDoesntChangePriceToNewOne(): void {
        $item = new CartItem(ProductId::generate(), 1, new Money(15.99));
        $cart = new Cart(CartId::generate(), [
            $item
        ]);
        $cart->addItem($item->productId(), 1, new Money(4.99));
        $updatedItem = $cart->findItem($item->productId());
        $this->assertSame(15.99, $updatedItem->priceAtAdd()->amount());
    }

    public static function cartItemsSets(): array {
        return [
            [1,1,0],
            [2,1,1],
            [1,2,0],
        ];
    }

    /**
     * @dataProvider cartItemsSets
     */
    public function testProductCanBeRemovedFromCart(int $initialQuantity, int $quantityToRemove, int $expectedLeft): void {
        $newProductId = ProductId::generate();
        $cart = new Cart(CartId::generate(), [
            new CartItem($newProductId, $initialQuantity, new Money(15.99))
        ]);

        $cart->removeItem($newProductId, $quantityToRemove);
        $this->assertCount($expectedLeft, $cart->items());
    }

    public function testProductToAddCantHaveZeroQuantity(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity must be greater than 0');

        $newProductId = ProductId::generate();
        $cart = new Cart(CartId::generate(), [
            new CartItem($newProductId, 1, new Money(15.99))
        ]);

        $cart->addItem($newProductId, 0, new Money(15.99));
    }

    public function testProductToRemoveCantHaveZeroQuantity(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity must be greater than 0');

        $newProductId = ProductId::generate();
        $cart = new Cart(CartId::generate(), [
            new CartItem($newProductId, 1, new Money(15.99))
        ]);

        $cart->removeItem($newProductId, 0);
    }

}