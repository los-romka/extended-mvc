<?php

declare(strict_types=1);

namespace LosRomka\Shop\View;

use LosRomka\Shop\Model\Cart;
use LosRomka\Shop\Session\CurrentUser;
use Twig\Environment;

class CartPage
{
    private Environment $twig;
    private CurrentUser $currentUser;

    public function __construct(Environment $twig, CurrentUser $currentUser)
    {
        $this->twig = $twig;
        $this->currentUser = $currentUser;
    }

    public function renderHtml(Cart $cart): string
    {
        $products = [];
        $counts = [];

        foreach ($cart->getProducts() as $product) {
            $counts[$product->getId()] ??= 0;
            $counts[$product->getId()]++;

            $products[$product->getId()] = $product;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->twig->render('cart.html.twig', [
            'products' => $products,
            'counts' => $counts,
            'currentUser' => $this->currentUser,
        ]);
    }
}
