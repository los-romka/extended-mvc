<?php

declare(strict_types=1);

namespace LosRomka\Shop\Session;

class CurrentUser
{
    public function getName(): string
    {
        return $_COOKIE['username'];
    }
}