<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CustomerController extends AbstractController
{
    public function __construct(private CustomerRepository $customerRepository, private EntityManagerInterface $entityManager, ) {}

    #[Route('/cus', name: 'app_customer')]
    public function index(): Response
    {
        $element = $this->customerRepository->findAll();

        return $this->render('customer/index.html.twig', [
            'elements' => $element,
        ]);
    }

    #[Route('/customer/create', name: 'customer_create')]
    public function create(Request $request): Response
    {
        $element = new Customer();

        $user = $this->getUser();

        $check = $this->customerRepository->findByUser($user);

        if(!($check==null)){
            return $this->redirectToRoute('app_customer');
        }

        $element->setUser($user);



        $repository = $this->entityManager->getRepository(Customer::class);
        do {
            $uniqueIdCards = mt_rand(1, 1000);
            $existingCustomer = $repository->findOneBy(['IdCards' => $uniqueIdCards]);
        } while ($existingCustomer);

        $element->setIdCards($uniqueIdCards);

        $element->setPoints(0);

        $form = $this->createForm(CustomerType::class, $element);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($element);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_customer');
        }

        return $this->render('customer/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/customer/update/{id}', name: 'customer_update', methods: ['GET', 'POST'])]
    public function update(Request $request, $id,AuthenticationUtils $authenticationUtils): Response
    {
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        $element = $this->customerRepository->find($id);

        if (!$element) {
            throw $this->createNotFoundException('Zamowienie o podanym ID nie istnieje.');
        }

        $form = $this->createForm(CustomerType::class, $element, [
            'isAdmin' => $isAdmin,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($element);
            $this->entityManager->flush();

            $this->addFlash('success', 'Zamowienie zostało zaktualizowane.');

            return $this->redirectToRoute('app_customer');
        }

        return $this->render('customer/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/customer/delete/{id}', name: 'customer_delete', methods: ['GET'])]
    public function delete(Request $request, $id): Response
    {
        $element = $this->customerRepository->find($id);

        if (!$element) {
            throw $this->createNotFoundException('Nie znaleziono zamówienia o podanym ID.');
        }


        $this->entityManager->remove($element);
        $this->entityManager->flush();


        return $this->redirectToRoute('app_customer');
    }
}

