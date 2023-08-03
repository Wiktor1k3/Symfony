<?php

namespace App\Controller;

use App\Entity\Converter;
use App\Form\ConverterType;
use App\Repository\ConverterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConverterController extends AbstractController
{
    public function __construct(private ConverterRepository $converterRepository, private EntityManagerInterface $entityManager) {}

    #[Route('/converter', name: 'list_converter')]
    public function index(): Response
    {
        $element = $this->converterRepository->findAll();

        return $this->render('converter/index.html.twig', [
            'element' => $element,
        ]);
    }

    #[Route('/converter/create', name: 'converter_create')]
    public function create(Request $request): Response
    {
        $element = new Converter();

        $form = $this->createForm(ConverterType::class, $element );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($element );
            $this->entityManager->flush();

            return $this->redirectToRoute('list_converter');
        }

        return $this->render('converter/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/converter/update/{id}', name: 'converter_update', methods: ['GET', 'POST'])]
    public function update(Request $request, $id): Response
    {

        $element  = $this->converterRepository->find($id);

        if (!$element ) {
            throw $this->createNotFoundException('converter o podanym ID nie istnieje.');
        }

        $form = $this->createForm(ConverterType::class, $element );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($element);
            $this->entityManager->flush();

            $this->addFlash('success', 'converter zostało zaktualizowane.');

            return $this->redirectToRoute('list_converter');
        }

        return $this->render('converter/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/converter/delete/{id}', name: 'converter_delete', methods: ['GET'])]
    public function delete(Request $request, $id): Response
    {
        $element = $this->converterRepository->find($id);

        if (!$element) {
            throw $this->createNotFoundException('Nie znaleziono converter o podanym ID.');
        }


        $this->entityManager->remove($element);
        $this->entityManager->flush();


        return $this->redirectToRoute('list_converter');
    }
}

