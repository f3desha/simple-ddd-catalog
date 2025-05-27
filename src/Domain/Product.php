<?php declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final class Product {

    public function __construct(
        private ProductId $id,
        private string $name,
        private string $description,
        private Link $image,
        private Money $price
    )
    {
        if (empty($name)) {
            throw new InvalidArgumentException("Product name cannot be empty");
        }
        if (strlen($name) > 255) {
            throw new InvalidArgumentException("Product name cannot be longer then 255 symbols long");
        }
        if (strlen($description) > 1000) {
            throw new InvalidArgumentException("Product description cannot be longer then 1000 symbols long");
        }
        if ($price->amount() === 0.0) {
            throw new InvalidArgumentException("Product price cannot be zero");
        }
    }

    public function id(): ProductId {
        return $this->id;
    }

    public function name(): string {
        return $this->name;
    }

    public function description(): string {
        return $this->description;
    }

    public function price(): Money {
        return $this->price;
    }

    public function image(): Link {
        return $this->image;
    }

}