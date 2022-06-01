<?php

declare(strict_types=1);

namespace LosRomka\Shop\Repository;

use JetBrains\PhpStorm\Pure;
use LosRomka\Shop\Model\Price;
use LosRomka\Shop\Model\Product;

class InMemoryProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Product[]
     */
    private array $data;

    public function __construct()
    {
        $this->data = [
            1 => (new Product('Каша манная', new Price(100)))->setId(1),
            2 => (new Product('Каша гречневая', new Price(50)))->setId(2),
        ];
    }

    #[Pure]
    public function findAll(): array
    {
        return $this->data;
    }

    public function find(int $id): Product
    {
        return $this->data[$id] ?? throw new \RuntimeException('product not found');
    }
}
