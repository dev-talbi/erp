<?php


namespace App\Controller;


use App\Entity\Quote;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class QuoteController extends AbstractController
{
    /**
     * @var ManagerRegistry
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

    }

    /**
     * @Route("/all/quotes", name="all_quotes")
     */
    public function showAll(): Response
    {
        $quotes = $this->doctrine->getRepository(Quote::class)->findAll();

        return $this->render('quote/allQuotes.html.twig', [
            'controller_name' => 'AllServicesController',
            'quotes'=> $quotes,
        ]);
    }

    /**
     * @Route("/add/quote", name="add_quote")
     */
    public function add(): Response
    {
        return $this->render('quote/create.html.twig', [
            'controller_name' => 'QuoteController',
        ]);
    }


    /**
     * @Route("/show/quote/{id}", name="show_one_quote")
     */
    public function show($id): Response
    {
        $service = $this->getDoctrine()->getRepository(Quote::class)->find($id);
        return $this->render('quote/showOne.html.twig', [
            'controller_name' => 'ShowOneController',
            'quote' => $service,
        ]);
    }

    /**
     * @Route("/download/quote/{id}", methods={"GET","HEAD"}, name="download_one_quote"))
     */
    public function downloadPdf($id)
    {
        $quoteRepository = $this->getDoctrine()->getRepository(Quote::class);
        $quote = $quoteRepository->findOneBy(['id'=> $id]);
        $services = $quote->getServices();
        $total = 0;
        $velocity = 0;

        foreach ($services as $service){
            $total += $service->getPrice() ;
            $velocity += $service->getVelocity();
        }
        $discount = number_format($total * ((100-$quote->getDiscount()) / 100), 2, ',', ' ');



        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsHtml5ParserEnabled(true);
        $pdfOptions->setIsRemoteEnabled(true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/quoteTemplate.html.twig', [
            'title' => "Welcome to our PDF Test",
            'quote' => $quote,
            'total' => $total,
            'discount' => $discount,
            'velocity' => $velocity
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
         $dompdf->stream("devis_zs_webservices.pdf", [
            "Attachment" => false
        ]);
         exit(0);
    }

    /**
     * @Route("/mail/quote/{id}", methods={"GET","HEAD"}, name="mail_one_quote"))
     */
    public function mailPdf($id, MailerInterface $mailer , Filesystem $filesystem)
    {
        $quoteRepository = $this->getDoctrine()->getRepository(Quote::class);
        $quote = $quoteRepository->findOneBy(['id'=> $id]);
        $services = $quote->getServices();
        $total = 0;
        $velocity = 0 ;

        foreach ($services as $service){
            $total += $service->getPrice() ;
            $velocity += $service->getVelocity();
        }
        $discount = number_format($total * ((100-$quote->getDiscount()) / 100), 2, ',', ' ');



        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsHtml5ParserEnabled(true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/quoteTemplate.html.twig', [
            'title' => "Devis",
            'quote' => $quote,
            'total' => $total,
            'discount' => $discount,
            'velocity' => $velocity
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public';;

        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath =  $publicDirectory . '/devis_zs_webservices.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);



        $email = (new TemplatedEmail())
            ->from(new Address('dev.talbi@gmail.com', 'ZS Webservices'))
            ->to('dev.talbi@gmail.com')
            ->htmlTemplate('email/quoteEmail.html.twig')
            ->subject('Devis')
            ->context([
                'quote' => $quote,
                'total' => $total,
                'discount' => $discount
            ])
            ->attachFromPath($publicDirectory . '/devis_zs_webservices.pdf');
        $mailer->send($email);

        $filesystem->remove($publicDirectory . '/devis_zs_webservices.pdf');


        return new Response("The PDF file has been succesfully generated !");

    }

}