<?php

declare(strict_types=1);

namespace LosRomka\Shop\Controller;

use LosRomka\Shop\Repository\ProductRepositoryInterface;
use LosRomka\Shop\View\ProductsPage;

class ProductsController
{
    private ProductRepositoryInterface $productsRepository;
    private ProductsPage $page;

    public function __construct(ProductRepositoryInterface $productRepository, ProductsPage $productsPage)
    {
        $this->page = $productsPage;
        $this->productsRepository = $productRepository;
    }

    public function listAction(): string
    {
        $products = $this->productsRepository->findAll();

        return $this->page->renderHtml($products);
    }
}