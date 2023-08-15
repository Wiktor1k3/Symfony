<?php

namespace App\Controller;

use App\Command\RemoveExpiredCartsCommand;
use App\Form\CustomCommandType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;

class OrderController extends AbstractController
{
    public function __construct(private OrderRepository $orderRepository, RemoveExpiredCartsCommand $cartsCommand){}

    #[Route('/order', name: 'app_order')]
    public function index(): Response
    {
        $element = $this->orderRepository->findAll();

        return $this->render('order/index.html.twig', [
            'elements' => $element,
        ]);
    }

    /**
     * @Route("/run-custom-command", name="run_custom_command")
     */
    public function runCustomCommand(RemoveExpiredCartsCommand $removeExpiredCartsCommand): Response
    {
        // Wywołanie Twojej własnej komendy
        $input = new ArrayInput([]);

        $output = new BufferedOutput();

        $statusCode = $removeExpiredCartsCommand->run($input, $output);

        $commandOutput = $output->fetch(); // Pobierz wynik działania komendy

        return $this->json(['output' => $commandOutput]);
    }
}

