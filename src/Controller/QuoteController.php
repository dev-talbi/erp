<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{

    /**
     * @Route("/add/quote", name="add_quote")
     */
    public function add(): Response
    {
        return $this->render('quote/create.html.twig', [
            'controller_name' => 'QuoteController',
        ]);
    }

}