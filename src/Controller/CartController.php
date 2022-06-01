<?php

declare(strict_types=1);

namespace LosRomka\Shop\Controller;

use LosRomka\Shop\Repository\CartRepositoryInterface;
use LosRomka\Shop\Repository\FilesystemCartRepository;
use LosRomka\Shop\Repository\InMemoryProductRepository;
use LosRomka\Shop\Repository\ProductRepositoryInterface;
use LosRomka\Shop\Session\CurrentUser;
use LosRomka\Shop\View\CartPage;

class CartController
{
    private ProductRepositoryInterface $productsRepository;
    private CartRepositoryInterface $cartRepository;
    private CurrentUser $currentUser;
    private CartPage $page;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CartRepositoryInterface $cartRepository,
        CurrentUser $currentUser,
        CartPage $page,
    ) {
        $this->productsRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->currentUser = $currentUser;
        $this->page = $page;
    }

    public function showAction(): string
    {
        $cart = $this->cartRepository->findByUser($this->currentUser->getName());

        return $this->page->renderHtml($cart);
    }

    public function addProductAction(int $productId): string
    {
        $product = $this->productsRepository->find($productId);

        $cart = $this->cartRepository->findByUser($this->currentUser->getName());

        $cart->add($product);

        $this->cartRepository->save($cart);

        header("Location: /");
        http_send_status(302);

        return 'Loading';
    }

    public function removeProductAction(int $productId): string
    {
        $product = $this->productsRepository->find($productId);

        $cart = $this->cartRepository->findByUser($this->currentUser->getName());

        $cart->remove($product);

        $this->cartRepository->save($cart);

        header("Location: /?action=cart");
        http_send_status(302);

        return 'Loading';
    }
}
