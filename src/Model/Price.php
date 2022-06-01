<?php

declare(strict_types=1);

namespace LosRomka\Shop\Model;

class Price
{
    private int $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public function getRoubles(): int
    {
        return $this->amount;
    }
}
