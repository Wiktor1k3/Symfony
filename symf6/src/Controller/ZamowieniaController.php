<?php

namespace App\Controller;

use App\Form\ZamowieniaType;
use App\Repository\ZamowieniaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Zamowienia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ZamowieniaController extends AbstractController
{
    public function __construct(private ZamowieniaRepository $zamowieniaRepository, private EntityManagerInterface $entityManager) {}

    #[Route('/zamowienia', name: 'lista_zamowien')]
    public function index(): Response
    {
        $zamowienia = $this->zamowieniaRepository->findAll();

        return $this->render('zamowienia/index.html.twig', [
            'zamowienia' => $zamowienia,
        ]);
    }

    #[Route('/zamowienie/create', name: 'zamowienie_create')]
    public function create(Request $request): Response
    {
        $zamowienia = new Zamowienia();

        $form = $this->createForm(ZamowieniaType::class, $zamowienia);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($zamowienia);
            $this->entityManager->flush();

            return $this->redirectToRoute('lista_zamowien');
        }

        return $this->render('zamowienia/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name: 'zamowienie_update', methods: ['GET', 'POST'])]
    public function update(Request $request, $id): Response
    {

        $zamowienie = $this->zamowieniaRepository->find($id);

        if (!$zamowienie) {
            throw $this->createNotFoundException('Zamowienie o podanym ID nie istnieje.');
        }

        $form = $this->createForm(ZamowieniaType::class, $zamowienie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($zamowienie);
            $this->entityManager->flush();

            $this->addFlash('success', 'Zamowienie zostało zaktualizowane.');

            return $this->redirectToRoute('lista_zamowien');
        }

        return $this->render('zamowienia/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'zamowienie_delete', methods: ['GET'])]
    public function delete(Request $request, $id): Response
    {
        $zamowienie = $this->zamowieniaRepository->find($id);

        if (!$zamowienie) {
            throw $this->createNotFoundException('Nie znaleziono zamówienia o podanym ID.');
        }


        $this->entityManager->remove($zamowienie);
        $this->entityManager->flush();


        return $this->redirectToRoute('lista_zamowien');
    }
}
