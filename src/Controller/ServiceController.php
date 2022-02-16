<?php

namespace App\Controller;

use App\Entity\Services;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @var ManagerRegistry
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

    }

    /**
     * @Route("/all/services", name="all_services")
     */
    public function showAll(): Response
    {
        $services = $this->doctrine->getRepository(Services::class)->findAll();

        return $this->render('service/allService.html.twig', [
            'controller_name' => 'AllServicesController',
            'services'=> $services,
        ]);
    }

    /**
     * @Route("/addservices", name="addservices")
     */
    public function add(): Response
    {
        return $this->render('service/addService.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    /**
     * @Route("/show/service/{id}", name="show_one_service", methods={"GET","POST"}))
     */
    public function show($id): Response
    {
        $service = $this->getDoctrine()->getRepository(Services::class)->find($id);
        return $this->render('service/showOne.html.twig', [
            'controller_name' => 'ShowOneController',
            'service' => $service,
        ]);
    }
}
