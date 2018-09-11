<?php
/**
 * Created by PhpStorm.
 * User: Khalil
 * Date: 05/04/2017
 * Time: 15:33
 */

namespace Eshop\UserBundle\Repository;




use Doctrine\ORM\EntityRepository;

class CommandesRepository extends EntityRepository
{
    public function byFacture($utilisateur)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.utilisateur = :utilisateur')

            ->orderBy('u.date', 'DESC')
            ->setParameter('utilisateur', $utilisateur);

        return $qb->getQuery()->getResult();
    }
}

