<?php

namespace App\Repository;

use App\Entity\Compostuser;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompostuserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Compostuser::class);
    }
    public function findByAllcomp()
    {
        return $this->createQueryBuilder('c')
               
             ->leftJoin("c.post",'p')   
             ->leftJoin("c.user",'u')  
             ->leftJoin("c.comment",'o')    
                 ->addselect("p")
                ->addselect("u")
                ->addselect("o")
            ->getQuery()
            ->getResult()
        ;
    }

}
