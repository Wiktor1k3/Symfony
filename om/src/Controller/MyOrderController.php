<?php

namespace App\Controller;

use App\Form\ProductType;
use App\Repository\CustomerRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyOrderController extends AbstractController
{
    public function __construct(private CustomerRepository $customerRepository, private EntityManagerInterface $entityManager,
                                private OrderRepository $orderRepository, private OrderItemRepository $itemRepository,
                                private ProductRepository$productRepository) {}

    #[Route('/my/order', name: 'app_my_order')]
    public function index(): Response
    {
        $user = $this->getUser();
        $isCustomer = $this->customerRepository->findByUser($user);

        if (!$isCustomer) {
            return $this->redirectToRoute("home");
        }

        $orders = $this->orderRepository->findByUser($user);

        return $this->render('my_order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/my/order/{id}', name: 'order_detail')]
    public function detailOrder(Request $request, $id): Response
    {
        $user = $this->getUser();
        $isCustomer = $this->customerRepository->findByUser($user);

        if (!$isCustomer) {
            return $this->redirectToRoute("home");
        }

        $item = $this->itemRepository->findByOrder($id);


        return $this->render('my_order/detail.html.twig', [
            'item' => $item,
        ]);
    }
}
