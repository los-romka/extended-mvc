<?php

declare(strict_types=1);

namespace LosRomka\Shop\Repository;

use LosRomka\Shop\Model\Cart;

interface CartRepositoryInterface
{
    public function findByUser(string $name): Cart;

    public function save(Cart $cart): void;
}