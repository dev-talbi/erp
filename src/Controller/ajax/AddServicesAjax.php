<?php


namespace App\Controller\ajax;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Services;

class AddServicesAjax extends AbstractController
{
    /**
     * @var ManagerRegistry
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

    }

    /**
     * @Route("/create_service_ajax", name="create_service_ajax",methods={"POST"})
     */
    public function create(Request $request){
        try {
            $entityManager = $this->doctrine->getManager();
            $createdAt = date('H:i:s  d/m/Y');
            $service = new Services();
            $service->setName($request->get("name"));
            $service->setDescription($request->get("description"));
            $service->setTime($createdAt);
            $entityManager->persist($service);
            $entityManager->flush();
            return new Response(json_encode(["create"]));
        }catch (\Exception $e){
            return new Response(json_encode(["result" => "FALSE", "message" => "Caught exception:" . $e->getMessage() . "~" . $e->getFile() . "~" . $e->getLine() . "~"]));
        }
    }




}