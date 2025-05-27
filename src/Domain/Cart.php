<?php declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final class Cart {
    /**
     * @var CartItem[]
     */
    private array $items = [];
    private CartStatus $status;

    public function __construct(
        private CartId $cartId,
        array $items,
        CartStatus $status = null
    ) {
        $this->items = $items;
        $this->status = $status ?? CartStatus::default();
    }

    public function id(): CartId {
        return $this->cartId;
    }

    public function items(): array {
        return $this->items;
    }

    public function status(): CartStatus {
        return $this->status;
    }

    public function findItem(ProductId $productId): ?CartItem
    {
        foreach ($this->items as $item) {
            if ($item->productId()->equals($productId)) {
                return $item;
            }
        }
        return null;
    }

    public function addItem(ProductId $productId, int $quantity, Money $price): void
    {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Quantity must be greater than 0');
        }
        foreach ($this->items as $i => $item) {
            if ($item->productId()->equals($productId)) {
                $this->items[$i] = new CartItem($productId, $item->quantity() + $quantity, $item->priceAtAdd());
                return;
            }
        }
        $this->items[] = new CartItem($productId, $quantity, $price);
    }

    public function removeItem(ProductId $productId, int $quantity): void {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Quantity must be greater than 0');
        }
        foreach ($this->items as $i => $item) {
            if ($item->productId()->equals($productId)) {
                if ($item->quantity() > $quantity) {
                    $this->items[$i] = new CartItem($productId, $item->quantity() - $quantity, $item->priceAtAdd());
                    return;
                }
                unset($this->items[$i]);
                return;
            }
        }
    }

}