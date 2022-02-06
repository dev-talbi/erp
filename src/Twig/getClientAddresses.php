<?php


namespace App\Twig;
use App\Entity\Addresses;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;


class getClientAddresses extends AbstractExtension
{
    /**
     * @var ManagerRegistry
     */


    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

    }
    public function getFunctions()
    {
        return [
            new TwigFunction('getClientAddresses', [$this, 'getClientAddresses']),
        ];
    }

    public function getClientAddresses($customerId)
    {
        $addressesRepository = $this->doctrine->getRepository(Addresses::class);
        $addresse = $addressesRepository->findOneBy(['client'=>$customerId]);

        return $addresse;

    }

}