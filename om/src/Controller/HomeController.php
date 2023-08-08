<?php

namespace App\Controller;

use App\Repository\ConverterRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $productRepository, ConverterRepository $converterRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findAll(),
            'department' => $converterRepository->findAll(),
        ]);
    }

    #[Route("/{department}", name: "department_search", methods: ['GET'])]
    public function department($department,ProductRepository $productRepository, ConverterRepository $converterRepository): Response
    {

        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findByDepartment($department),
            'department' => $converterRepository->findAll(),
        ]);
    }
}

