<?php

declare(strict_types=1);

namespace LosRomka\Shop\Model;

class Cart
{
    /**
     * @var Product[]
     */
    private array $products = [];
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function add(Product $product): void
    {
        $this->products [] = $product;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        usort($this->products, static fn (Product $a, Product $b) => $a->getName() <=> $b->getName());

        return $this->products;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function remove(Product $productToRemove): void
    {
        $idx = null;

        foreach ($this->products as $i => $product) {
            if ($product->getId() === $productToRemove->getId()) {
                $idx = $i;
                break;
            }
        }

        if ($idx !== null) {
            array_splice($this->products, $idx, 1);
        }
    }
}
