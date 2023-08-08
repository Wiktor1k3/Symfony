<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ImageUploadType;

class ImageController extends AbstractController
{
/**
* @Route("/upload_image", name="upload_image")
*/
public function uploadImage(Request $request)
{
$form = $this->createForm(ImageUploadType::class);

$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {
$imageFile = $form->get('file')->getData();

// Zapisz zdjęcie do docelowego katalogu
$uploadsDirectory = $this->getParameter('uploads_directory');
$imageName = uniqid().'.'.$imageFile->guessExtension();
$imageFile->move($uploadsDirectory, $imageName);

// Tutaj możesz dodać kod do zapisu informacji o zdjęciu do bazy danych, jeśli wymagane
}

return $this->render('upload_image.html.twig', [
'form' => $form->createView(),
]);
}
}