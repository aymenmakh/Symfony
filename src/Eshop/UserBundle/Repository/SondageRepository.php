<?php
namespace Eshop\UserBundle\Repository;
/**
 * Created by PhpStorm.
 * User: khlifa
 * Date: 18/03/2017
 * Time: 12:54
 */


use Doctrine\ORM\EntityRepository;

class SondageRepository extends EntityRepository
{

    public function countReponseByQuestion($id_question)
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(r.id) FROM EshopUserBundle:Reponse r WHERE r.idQuestion=:id_question")->setParameter('id_question',$id_question);
        return $query->getSingleResult();

    }

}