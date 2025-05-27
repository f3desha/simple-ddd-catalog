<?php

namespace App\Controller;

use App\Domain\Link;
use App\Domain\Money;
use App\Domain\Product;
use App\Domain\ProductId;
use App\Domain\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WebController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/', name: 'app_web')]
    public function index(): Response
    {
        $this->productRepository->save(new Product(
            ProductId::generate(),
            'Smartphone X',
            'Latest smartphone with advanced features and high-resolution camera.',
            new Link('https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=300&h=200&fit=crop'),
            new Money(599.99)
        ));
        $this->productRepository->save(new Product(
            ProductId::generate(),
            'Wireless Headphones',
            'Premium noise-cancelling headphones with long battery life.',
            new Link('https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=200&fit=crop'),
            new Money(149.99)
        ));
        $this->productRepository->save(new Product(
            ProductId::generate(),
            'Smartwatch Pro',
            'Feature-rich smartwatch with health monitoring and GPS.',
            new Link('https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300&h=200&fit=crop'),
            new Money(249.99)
        ));
        $this->productRepository->save(new Product(
            ProductId::generate(),
            'Laptop Ultra',
            'Powerful laptop with high-performance processor and dedicated graphics.',
            new Link('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=200&fit=crop'),
            new Money(1299.99)
        ));
        $this->productRepository->save(new Product(
            ProductId::generate(),
            'Bluetooth Speaker',
            'Portable speaker with rich sound and waterproof design.',
            new Link('https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=300&h=200&fit=crop'),
            new Money(79.99)
        ));
        $this->productRepository->save(new Product(
            ProductId::generate(),
            'Digital Camera',
            'Professional camera with high-resolution sensor and interchangeable lenses.',
            new Link('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=300&h=200&fit=crop'),
            new Money(899.99)
        ));

        return $this->render('web/index.html.twig', [
            'products' => $this->productRepository->findAll(),
        ]);
    }
}
