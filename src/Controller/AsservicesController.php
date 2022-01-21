<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AsservicesController extends AbstractController
{
    /**
     * @Route("/asservices", name="asservices")
     */
    public function index(): Response
    {
        return $this->render('asservices/index.html.twig', [
            'controller_name' => 'AsservicesController',
        ]);
    }
}
