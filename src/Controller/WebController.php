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
        return $this->render('web/index.html.twig', [
            'products' => $this->productRepository->findAll(),
        ]);
    }
}
