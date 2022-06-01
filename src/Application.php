<?php

declare(strict_types=1);

namespace LosRomka\Shop;


use LosRomka\Shop\Controller\CartController;
use LosRomka\Shop\Controller\ProductsController;
use LosRomka\Shop\DI\ServiceLocator;
use LosRomka\Shop\Repository\DummyProductRepository;
use LosRomka\Shop\Repository\FilesystemCartRepository;
use LosRomka\Shop\Repository\InMemoryProductRepository;
use LosRomka\Shop\Repository\ProductRepositoryInterface;
use LosRomka\Shop\Session\CurrentUser;
use LosRomka\Shop\View\CartPage;
use LosRomka\Shop\View\ProductsPage;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Application
{
    private ServiceLocator $serviceLocator;

    public function __construct()
    {
        $this->serviceLocator = $this->initServices();
    }

    public function run(): string
    {
        if (!empty($_POST) && $_GET['action'] === 'remove_from_cart') {
            return $this->serviceLocator->get(CartController::class)->removeProductAction((int)$_POST['product_id']);
        }

        if (!empty($_POST) && $_GET['action'] === 'add_to_cart') {
            return $this->serviceLocator->get(CartController::class)->addProductAction((int)$_POST['product_id']);
        }

        if (($_GET['action'] ?? '') === 'cart') {
            return $this->serviceLocator->get(CartController::class)->showAction();
        }

        return $this->serviceLocator->get(ProductsController::class)->listAction();
    }

    private function initServices(): ServiceLocator
    {
        $serviceLocator = new ServiceLocator();

        $serviceLocator->set(ProductRepositoryInterface::class, new InMemoryProductRepository());

        $serviceLocator->set('twig', new Environment(
            new FilesystemLoader(dirname(__DIR__) . '/templates')
        ));

        $serviceLocator->set(ProductsController::class, function(ServiceLocator $serviceLocator) {
            return new ProductsController(
                $serviceLocator->get(ProductRepositoryInterface::class),
                new ProductsPage($serviceLocator->get('twig'))
            );
        });

        $serviceLocator->set(CurrentUser::class, new CurrentUser());

        $serviceLocator->set(CartController::class, new CartController(
            $serviceLocator->get(ProductRepositoryInterface::class),
            new FilesystemCartRepository($serviceLocator->get(ProductRepositoryInterface::class)),
            $serviceLocator->get(CurrentUser::class),
            new CartPage(
                $serviceLocator->get('twig'),
                $serviceLocator->get(CurrentUser::class)
            )
        ));

        return $serviceLocator;
    }
}
