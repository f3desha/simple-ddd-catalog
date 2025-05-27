<?php declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final class CartItem {

    public function __construct(
        private ProductId $productId,
        private int $quantity,
        private Money $priceAtAdd
    ) {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Quantity must be at least 1');
        }
    }

    public function productId(): ProductId {
        return $this->productId;
    }

    public function quantity(): int {
        return $this->quantity;
    }

    public function priceAtAdd(): Money {
        return $this->priceAtAdd;
    }

}