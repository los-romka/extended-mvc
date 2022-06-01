<?php

declare(strict_types=1);

namespace LosRomka\Shop\Repository;

use LosRomka\Shop\Model\Product;

class DummyProductRepository implements ProductRepositoryInterface
{
    public function findAll(): array
    {
        return [];
    }

    public function find(int $id): Product
    {
        throw new \RuntimeException();
    }
}
