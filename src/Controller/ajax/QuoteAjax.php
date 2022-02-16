<?php


namespace App\Controller\ajax;
use App\Entity\Addresses;
use App\Entity\Client;
use App\Entity\Quote;
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

    // send all services to select2
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

    // fill in the fields for selected service
    /**
     * @Route("/get/all/data/ajax", name="get_all_data",methods={"POST"})
     */

    public function sendAllData(Request $request){
        $data = $request->get('data');
        try {
            $serviceRepository = $this->doctrine->getRepository(Services::class);
            $allData = $serviceRepository->findOneBy(['name'=>$data]);

            $response['id'] = $allData->getId();
            $response['description'] = $allData->getDescription();
            $response['price'] = $allData->getPrice();
            $response['velocity'] = $allData->getVelocity();




            return $this->json($response);

        }catch (\Exception $e){
            return new Response(json_encode(["result" => "FALSE", "message" => "Caught exception:" . $e->getMessage() . "~" . $e->getFile() . "~" . $e->getLine() . "~"]));
        }

    }

    /**
     * @Route("/create/quote/ajax", name="create_quote_ajax",methods={"POST"})
     */
    public function createQuote(Request $request){
        try {
            $data = $request->get('formData');
            $service_datas = $request->get('servicesData');
            parse_str($data, $clientData);
            $time = new \DateTime();
            $time->format('H:i:s \O\n Y-m-d');
            $entityManager = $this->doctrine->getManager();
            $serviceRepository = $this->doctrine->getRepository(Services::class);
            if (!empty($client_datas['client_id'])){
                dd('not empty');
            }else{
                $client = new Client();
                $addresse = new Addresses();

                $addresse->setCompany($clientData['company']);
                $addresse->setCity($clientData['city']);
                $addresse->setStreet($clientData['street']);
                $addresse->setPostale($clientData['postale']);
                $addresse->setCountry($clientData['country']);
                $addresse->setType('test');
                $entityManager->persist($addresse);

                $client->setLastname($clientData['lastname']);
                $client->setCompany($clientData['company']);
                $client->setPhone($clientData['phone']);
                $client->setLanguage($clientData['language']);
                $client->setFirstname($clientData['firstname']);
                $client->setSiret($clientData['siret']);
                $client->setEmail($clientData['email']);
                $client->addAddress($addresse);
                $entityManager->persist($client);
            }
            $quote = new Quote();
            foreach ($service_datas as $service){
                foreach ($service['id'] as $key => $value){
                    $addService = $serviceRepository->findOneBy(['id'=>$value]);
                    $quote->addService($addService);
                }
            }
            $quote->setCreationDate($time);
            $quote->setClient($client);
            $quote->setDeposit($clientData['deposit']);
            $quote->setStatus('test');
            $quote->setDiscount($clientData['discount']);
            $entityManager->persist($quote);
            $entityManager->flush();

            return new Response(json_encode(["success" ]));


        }catch (\Exception $e){
            return new Response(json_encode(["result" => "FALSE", "message" => "Caught exception:" . $e->getMessage() . "~" . $e->getFile() . "~" . $e->getLine() . "~"]));
        }

    }

    /**
     * @Route("/edit/quote/ajax", name="edit_quote_ajax",methods={"POST"})
     */
    public function editeQuote(Request $request){
        try {
            $data = $request->get('formData');
            $service_datas = $request->get('servicesData');

            parse_str($data, $clientData);
            $time = new \DateTime();
            $time->format('H:i:s \O\n Y-m-d');
            $entityManager = $this->doctrine->getManager();
            $serviceRepository = $this->doctrine->getRepository(Services::class);
            $clientRepository = $this->doctrine->getRepository(Client::class);
            $addresRepository = $this->doctrine->getRepository(Addresses::class);
            $quoteRepository = $this->doctrine->getRepository(Quote::class);
            $clientId =  $clientData['client_id'];
            $client = $clientRepository->findOneBy(['id'=> $clientId]);
            $addresse = $addresRepository->findOneBy(['client'=>$client]);
            $quote = $quoteRepository->findOneBy(['id'=>$clientData['quote_id']]);
            $services = $quote->getServices();

            foreach ($services as $serviceItem ){
                $quote->removeService($serviceItem);
                $entityManager->flush();
            }

            $addresse->setCompany($clientData['company']);
                $addresse->setCity($clientData['city']);
                $addresse->setStreet($clientData['street']);
                $addresse->setPostale($clientData['postale']);
                $addresse->setCountry($clientData['country']);
                $addresse->setType('test');

                $client->setLastname($clientData['lastname']);
                $client->setCompany($clientData['company']);
                $client->setPhone($clientData['phone']);
                $client->setLanguage($clientData['language']);
                $client->setFirstname($clientData['firstname']);
                $client->setSiret($clientData['siret']);
                $client->setEmail($clientData['email']);
                $client->addAddress($addresse);


            foreach ($service_datas as $service){
                foreach ($service['id'] as $key => $value){
                    $addService = $serviceRepository->findOneBy(['id'=>$value]);
                    $quote->addService($addService);
                    $entityManager->persist($quote);
                    $entityManager->flush();
                }
            }
            $quote->setCreationDate($time);
            $quote->setClient($client);
            $quote->setDeposit($clientData['deposit']);
            $quote->setStatus('test');
            $quote->setDiscount($clientData['discount']);
            $entityManager->flush();

            return new Response(json_encode(["success" ]));


        }catch (\Exception $e){
            return new Response(json_encode(["result" => "FALSE", "message" => "Caught exception:" . $e->getMessage() . "~" . $e->getFile() . "~" . $e->getLine() . "~"]));
        }

    }





}