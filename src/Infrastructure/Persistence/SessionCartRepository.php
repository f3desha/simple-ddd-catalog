<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence;


use App\Domain\Cart;
use App\Domain\CartId;
use App\Domain\Repository\CartRepository;

final class SessionCartRepository implements CartRepository {

    public function save(Cart $cart): void {
        $_SESSION[$cart->id()->value()] = $cart;
    }

    public function remove(CartId $id): void {
        unset($_SESSION[$id->value()]);
    }

    public function getById(CartId $id): ?Cart {
        return $_SESSION[$id->value()] ?? null;
    }
}