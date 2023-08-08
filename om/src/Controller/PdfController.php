<?php

namespace App\Controller;

    use Dompdf\Dompdf;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use App\Form\OrderType;
    use App\Entity\Order;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function generatePdf(Request $request)
    {
        // Tworzymy nowy obiekt klasy Order
        $order = new Order();

        // Tworzymy formularz OrderType, przekazując mu obiekt $order jako dane do wypełnienia
        $form = $this->createForm(OrderType::class, $order);

        // Obsługujemy żądanie POST
        $form->handleRequest($request);

        // Sprawdzamy, czy formularz został wysłany i jest prawidłowy
        if ($form->isSubmitted() && $form->isValid()) {
            // Renderujemy szablon HTML z danymi z formularza
            $html = $this->renderView('pdf/aha.html.twig', [
                'order' => $order,
            ]);

            // Inicjalizujemy Dompdf
            $dompdf = new Dompdf();

            // Ładujemy zawartość HTML do Dompdf
            $dompdf->loadHtml($html);

            // Opcjonalnie: Konfigurujemy Dompdf
            $dompdf->setPaper('A4', 'portrait');

            // Renderujemy PDF-a
            $dompdf->render();

            // Pobieramy zawartość PDF-a jako string
            $pdfOutput = $dompdf->output();

            // Zwracamy odpowiedź zawierającą wygenerowany PDF
            $pdfOutput = $dompdf->output();

            // Zapisz zawartość PDF-a do pliku w katalogu tymczasowym
            $tmpPdfFile = sys_get_temp_dir() . '/order.pdf';
            file_put_contents($tmpPdfFile, $pdfOutput);

            // Przygotuj odpowiedź do pobrania pliku
            $response = new Response(file_get_contents($tmpPdfFile));
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="order.pdf"');

            // Usuń plik tymczasowy
            unlink($tmpPdfFile);

            return $response;

        }

        // Jeśli formularz nie został jeszcze wysłany lub jest nieprawidłowy, wyświetlamy formularz
        return $this->render('pdf/index.html.twig', [
            'order' => $form->createView(),
        ]);
    }
}

