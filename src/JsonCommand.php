<?php


namespace App;

use App\Entity\Addresses;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;

class JsonCommand extends Command
{
    protected static $defaultName = 'app:plop';
    /**
     * @var Serializer
     */
    private $serializer;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct( EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    /**
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $class = $this->em->getClassMetadata(Addresses::class);
        $fields = [];
        if (!empty($class->discriminatorColumn)) {
            $fields[] = $class->discriminatorColumn['name'];
        }
        $fields = array_merge($class->getColumnNames(), $fields);
        foreach ($fields as $index => $field) {
            if ($class->isInheritedField($field)) {
                unset($fields[$index]);
            }
        }
        foreach ($class->getAssociationMappings() as $name => $relation) {
            if (!$class->isInheritedAssociation($name)){
                foreach ($relation['joinColumns'] as $joinColumn) {
                    $fields[] = $joinColumn['name'];
                }
            }
        }
        dd(json_encode($fields)) ;

    }

}