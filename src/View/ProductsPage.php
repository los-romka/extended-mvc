<?php

declare(strict_types=1);

namespace LosRomka\Shop\View;

use LosRomka\Shop\Model\Product;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ProductsPage
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $loader = new FilesystemLoader(__DIR__);

        $this->twig = $twig;
    }

    /**
     * @param Product[] $products
     *
     * @return string
     */
    public function renderHtml(array $products): string
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->twig->render('products.html.twig', ['products' => $products]);
    }
}
