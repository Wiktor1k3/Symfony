<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;

class OrderController extends AbstractController
{
    public function __construct(private OrderRepository $orderRepository){}

    #[Route('/order', name: 'app_order')]
    public function index(): Response
    {

        $element = $this->orderRepository->findAll();
        return $this->render('order/index.html.twig', [
            'elements' => $element,
        ]);
    }
}

