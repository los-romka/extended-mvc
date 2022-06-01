<?php

declare(strict_types=1);

namespace LosRomka\Shop\Repository;

use LosRomka\Shop\Model\Cart;
use LosRomka\Shop\Model\User;

class FilesystemCartRepository implements CartRepositoryInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function findByUser(string $name): Cart
    {
        $productIds = [];

        try {
            $content = file_get_contents($this->getFilePath($name));

            if (!empty($content)) {
                $productIds = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
            }
        } catch (\JsonException $exception) {
        }

        $cart = new Cart(new User($name));

        foreach ($productIds as $productId) {
            $product = $this->productRepository->find($productId);

            $cart->add($product);
        }

        return $cart;
    }

    public function save(Cart $cart): void
    {
        $products = $cart->getProducts();

        $productsIds = [];
        foreach ($products as $product) {
            $productsIds[] = $product->getId();
        }

        file_put_contents($this->getFilePath($cart->getUser()->getName()), json_encode($productsIds));
    }

    private function getFilePath(string $name): string
    {
        return dirname(__DIR__, 2) . '/var/cart_' . sha1($name);
    }
}
