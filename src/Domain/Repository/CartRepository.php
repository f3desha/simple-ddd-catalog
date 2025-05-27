<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Cart;
use App\Domain\CartId;

interface CartRepository {
    public function save(Cart $cart): void;

    public function remove(CartId $id): void;

    public function getById(CartId $id): ?Cart;

}