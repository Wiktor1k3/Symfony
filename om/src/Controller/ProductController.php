<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddToCartType;
use App\Form\ProductType;
use App\Manager\CartManager;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    public function __construct(private ProductRepository $productRepository, private EntityManagerInterface $entityManager) {}

    #[Route('/product', name: 'list_product')]
    public function index(): Response
    {
        $element = $this->productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'element' => $element,
        ]);
    }

    #[Route('/product/create', name: 'product_create')]
    public function create(Request $request): Response
    {
        $element = new Product();

        $form = $this->createForm(ProductType::class, $element );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($element );
            $this->entityManager->flush();

            return $this->redirectToRoute('list_product');
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/update/{id}', name: 'product_update', methods: ['GET', 'POST'])]
    public function update(Request $request, $id): Response
    {

        $element  = $this->productRepository->find($id);

        if (!$element ) {
            throw $this->createNotFoundException('product o podanym ID nie istnieje.');
        }

        $form = $this->createForm(ProductType::class, $element );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($element);
            $this->entityManager->flush();

            $this->addFlash('success', 'product zostało zaktualizowane.');

            return $this->redirectToRoute('list_product');
        }

        return $this->render('converter/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/delete/{id}', name: 'product_delete', methods: ['GET'])]
    public function delete(Request $request, $id): Response
    {
        $element = $this->productRepository->find($id);

        if (!$element) {
            throw $this->createNotFoundException('Nie znaleziono product o podanym ID.');
        }


        $this->entityManager->remove($element);
        $this->entityManager->flush();


        return $this->redirectToRoute('list_product');
    }

    #[Route('/product/shop/{id}', name: 'product_detail')]

    public function detail(Product $product, Request $request, CartManager $cartManager)
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProduct($product);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addItem($item)
                ->setUpdatedAt(new \DateTimeImmutable());

            $cartManager->save($cart);

            return $this->redirectToRoute('product_detail', ['id' => $product->getId()]);
        }

        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}

