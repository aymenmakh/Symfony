<?php
namespace Eshop\UserBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Eshop\UserBundle\Echange;
use Eshop\UserBundle\Entity;

class ReclamationRepository extends EntityRepository
{
    public function findmotifQB($motif)
    {
        $qb = $this->getEntityManager()
            ->createQuery("select m from EshopUserBundle:Reclamation m WHERE m.motif=:motif")

            ->setParameter('motif', $motif);
        return $qb->getResult();
    }









    public function CalculNbRec()
    {
        $qb = $this->getEntityManager()
            ->createQuery("select COUNT(m.id) from EshopUserBundle:Reclamation m WHERE m.etat='non traité' OR m.etat=''");

          return $result= $qb->getSingleScalarResult();

    }



    function findparamDQL($motif)
    {
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Reclamation a WHERE a.motif=:motif")
            ->setParameter('motif',$motif);

        return $query->getResult();
    }



    function rechDQL($cat)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from EshopUserBundle:Echange v where v.idcat.nom=:$cat ")
            ->setParameter('cat',$cat);
        return $query->getResult();
    }

}