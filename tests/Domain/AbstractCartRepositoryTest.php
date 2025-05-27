<?php declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Cart;
use App\Domain\CartId;
use App\Domain\Repository\CartRepository;
use PHPUnit\Framework\TestCase;

abstract class AbstractCartRepositoryTest extends TestCase {
    private CartRepository $repository;
    abstract public function createRepository(): CartRepository;

    protected function setUp(): void {
        $this->repository = $this->createRepository();
    }

    public function testItSavesAndFindsCart(): void {
        $cartId = CartId::generate();
        $this->repository->save(new Cart($cartId, []));
        $cart = $this->repository->getById($cartId);

        $this->assertNotNull($cart);
        $this->assertInstanceOf(Cart::class, $cart);
    }


    public function testItRemovesCart(): void {
        $cartId = CartId::generate();
        $this->repository->save(new Cart($cartId, []));
        $cart = $this->repository->getById($cartId);

        $this->assertNotNull($cart);
        $this->assertInstanceOf(Cart::class, $cart);

        $this->repository->remove($cartId);
        $product = $this->repository->getById($cartId);
        $this->assertNull($product);
    }

}