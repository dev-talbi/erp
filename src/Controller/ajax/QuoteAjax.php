<?php


namespace App\Controller\ajax;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Services;

class QuoteAjax extends AbstractController
{
    /**
     * @var ManagerRegistry
     */


    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

    }

    /**
     * @Route("/get/service/ajax", name="get_service_ajax",methods={"GET"})
     */
    public function getService(Request $request){
        $result = array();
        $data = array();
        $search = $request->get('searchTerm');

        try {
            $serviceRepository = $this->doctrine->getRepository(Services::class);

            if (is_null($search)) {
                $responses = $serviceRepository->findAll();
            } else {
                $responses = $serviceRepository->findLikeName($search);
            }



            /** @var Services $responses */
            foreach ($responses as $response) {
                $result[] = new \ArrayObject(['id' => $response->getName(), 'text' => $response->getName()]);
            }
            return $this->json($result);

        }catch (\Exception $e){
            return new Response(json_encode(["result" => "FALSE", "message" => "Caught exception:" . $e->getMessage() . "~" . $e->getFile() . "~" . $e->getLine() . "~"]));
        }
    }

    /**
     * @Route("/get/all/data/ajax", name="get_all_data",methods={"POST"})
     */

    public function sendAllData(Request $request){
        $data = $request->get('data');
        try {
            $serviceRepository = $this->doctrine->getRepository(Services::class);
            $allData = $serviceRepository->findBy(['name'=>$data]);

            return $this->json($allData);



        }catch (\Exception $e){
            return new Response(json_encode(["result" => "FALSE", "message" => "Caught exception:" . $e->getMessage() . "~" . $e->getFile() . "~" . $e->getLine() . "~"]));
        }

    }





}