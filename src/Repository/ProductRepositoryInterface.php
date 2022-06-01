<?php

declare(strict_types=1);

namespace LosRomka\Shop\Repository;

use LosRomka\Shop\Model\Product;

interface ProductRepositoryInterface
{
    /**
     * @return Product[]
     */
    public function findAll(): array;

    public function find(int $id): Product;
}
