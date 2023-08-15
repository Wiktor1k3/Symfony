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
    public function index(Request $request,ProductRepository $productRepository, ConverterRepository $converterRepository): Response
    {


        $startingRow = 1; // Numer wiersza, od którego chcesz zacząć
        $numberOfRows = 12; // Przykładowa liczba wierszy do odczytania

        $sort = $request->query->get('sort', 'default_sort_column');

        if ($sort === 'asc') {
            $queryBuilder = $productRepository->createQueryBuilder('e')
                ->orderBy('e.price', 'ASC')
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        } elseif ($sort === 'desc') {
            $queryBuilder = $productRepository->createQueryBuilder('e')
                ->orderBy('e.price', 'DESC')
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        } else {
            $queryBuilder = $productRepository->createQueryBuilder('e')
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        }


        $results = $queryBuilder->getQuery()->getResult();

        $idDown=1;




        return $this->render('home/index.html.twig', [
            'products' => $results,
            'department' => $converterRepository->findAll(),
            'idDown' => $idDown,
            'idUp' => 12,
            'sort' => $sort, // Przekazanie sortowania do szablonu
        ]);
    }

    #[Route("products/{department}", name: "department_start", methods: ['GET'])]
    public function departmentStart(Request $request, $department,ProductRepository $productRepository, ConverterRepository $converterRepository): Response
    {
        $sort = $request->query->get('sort', 'default_sort_column');
        $startingRow = 1; // Numer wiersza, od którego chcesz zacząć
        $numberOfRows = 3; // Przykładowa liczba wierszy do odczytania


        $queryBuilder = $productRepository->createQueryBuilder('p')
            ->where('p.department = :department')
            ->setParameter('department', $department)
            ->setFirstResult($startingRow - 1)
            ->setMaxResults($numberOfRows);

        $results = $queryBuilder->getQuery()->getResult();

        $idDown=1;


        return $this->render('home/index.html.twig', [
            'products' => $results,
            'department' => $converterRepository->findAll(),
            'idDown' => $idDown,
            'idUp' => 12,
            'departmentCurrent' => $department,
            'sort' => $sort, // Przekazanie sortowania do szablonu
        ]);
    }

    #[Route("products/{department}/{id}", name: "department_page", methods: ['GET'])]
    public function department(Request $request, $department,$id,ProductRepository $productRepository, ConverterRepository $converterRepository): Response
    {

        $startingRow = $id; // Numer wiersza, od którego chcesz zacząć
        $numberOfRows = 3; // Przykładowa liczba wierszy do odczytania

        if($id<1){
            $startingRow=1;
        }

        $sort = $request->query->get('sort', 'default_sort_column');

        if ($sort === 'asc') {
            $queryBuilder = $productRepository->createQueryBuilder('p')
                ->where('p.department = :department')
                ->setParameter('department', $department)
                ->orderBy('p.price', 'ASC')
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        } elseif ($sort === 'desc') {
            $queryBuilder = $productRepository->createQueryBuilder('p')
                ->where('p.department = :department')
                ->setParameter('department', $department)
                ->orderBy('p.price', 'DESC')
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        } else {
            $queryBuilder = $productRepository->createQueryBuilder('p')
                ->where('p.department = :department')
                ->setParameter('department', $department)
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        }


        $results = $queryBuilder->getQuery()->getResult();

        if($id<=12){
            $idDown=1;
        }
        else{
            $idDown = $id-12;
        }

        return $this->render('home/index.html.twig', [
            'products' => $results,
            'department' => $converterRepository->findAll(),
            'departmentCurrent' => $department,
            'idDown' => $idDown,
            'idUp' => $id+12,
            'sort' => $sort, // Przekazanie sortowania do szablonu
        ]);
    }



    #[Route("products/page/{id}", name: "id_page", methods: ['GET'])]
    public function pageID(Request $request, $id,ProductRepository $productRepository, ConverterRepository $converterRepository): Response
    {
        $startingRow = $id; // Numer wiersza, od którego chcesz zacząć
        $numberOfRows = 12; // Przykładowa liczba wierszy do odczytania

        $sort = $request->query->get('sort', 'default_sort_column');

        if ($sort === 'asc') {
            $queryBuilder = $productRepository->createQueryBuilder('p')
                ->orderBy('p.price', 'ASC')
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        } elseif ($sort === 'desc') {
            $queryBuilder = $productRepository->createQueryBuilder('p')
                ->orderBy('p.price', 'DESC')
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        } else {
            $queryBuilder = $productRepository->createQueryBuilder('p')
                ->setFirstResult($startingRow - 1) // -1, ponieważ indeksy w bazie danych zaczynają się od 0
                ->setMaxResults($numberOfRows);
        }

        $results = $queryBuilder->getQuery()->getResult();

        if($id<=12){
            $idDown=1;
        }
        else{
            $idDown = $id-12;
        }

        return $this->render('home/index.html.twig', [
            'products' => $results,
            'department' => $converterRepository->findAll(),
            'idDown' => $idDown,
            'idUp' => $id+12,
            'sort' => $sort, // Przekazanie sortowania do szablonu

        ]);
    }

}

