<?php


namespace App\Controller;


use App\Entity\Quote;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/add/quote", name="add_quote")
     */
    public function add(): Response
    {
        return $this->render('quote/create.html.twig', [
            'controller_name' => 'QuoteController',
        ]);
    }

    /**
     * @Route("/all/quotes", name="all_quotes")
     */
    public function delete(): Response
    {
        $quotes = $this->doctrine->getRepository(Quote::class)->findAll();

        return $this->render('quote/allQuotes.html.twig', [
            'controller_name' => 'AllServicesController',
            'quotes'=> $quotes,
        ]);
    }

    /**
     * @Route("/show/quote/{id}", name="show_one_quote", methods={"GET","POST"}))
     */
    public function show($id): Response
    {
        $service = $this->getDoctrine()->getRepository(Quote::class)->find($id);
        return $this->render('quote/showOne.html.twig', [
            'controller_name' => 'ShowOneController',
            'quote' => $service,
        ]);
    }

}