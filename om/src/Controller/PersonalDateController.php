<?php

namespace App\Controller;

use App\Entity\PersonalDate;
use App\Form\PersonalDateType;
use App\Repository\ConverterRepository;
use App\Repository\CustomerRepository;
use App\Repository\PersonalDateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonalDateController extends AbstractController
{
    public function __construct(private PersonalDateRepository $personalDateRepository,
                                private EntityManagerInterface $entityManager,
                                private CustomerRepository $customerRepository) {}

    #[Route('/personal/date', name: 'app_personal_date')]
    public function index(): Response
    {
        $user = $this->getUser();
        $personalDate = $this->personalDateRepository->findByUser($user);
        $isCustomer = $this->customerRepository->findByUser($user);

        if (!$personalDate AND !$isCustomer ){
            return $this->render('personal_date/index.html.twig', [
                'user' => $user,
            ]);
        }

        if($isCustomer AND $personalDate){
            return $this->render('personal_date/index.html.twig', [
                'element' => $personalDate,
                'user' => $user,
                'customer' => $isCustomer,
            ]);
        }

        if($isCustomer AND !$personalDate){
            return $this->render('personal_date/index.html.twig', [
                'user' => $user,
                'customer' => $isCustomer,
            ]);
        }

        return $this->render('personal_date/index.html.twig', [
            'element' => $personalDate,
            'user' => $user,
        ]);
    }

    #[Route('/personal/date/create', name: 'personal_create')]
    public function create(Request $request): Response
    {
        $element = new PersonalDate();

        $user = $this->getUser();

        $check = $this->personalDateRepository->findByUser($user);

        if(!($check==null)){
            return $this->redirectToRoute('app_personal_date');
        }

        $element->setUser($user);

        $form = $this->createForm(PersonalDateType::class, $element);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($element);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_personal_date');
        }


        return $this->render('personal_date/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
