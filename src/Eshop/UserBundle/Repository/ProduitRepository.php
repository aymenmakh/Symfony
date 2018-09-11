<?php
namespace Eshop\UserBundle\Repository;
/**
 * Created by PhpStorm.
 * User: Khalil
 * Date: 18/03/2017
 * Time: 12:54
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
    public function findArray($array)
    {
        $qb = $this->createQueryBuilder('u')
            ->Select('u')
            ->Where('u.id IN (:array)')
            ->setParameter('array', $array);
        return $qb->getQuery()->getResult();
    }
    function findByEnPromotionDQL(){
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Produit a where a.Enpromotion= '1' ");
        return $query->getResult();

    }
    function catVDQL()
    {
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Produit a where a.idCategorie=4");


        return $query->getResult();
    }



    function catTDQL()
    {
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Produit a where a.idCategorie=6");


        return $query->getResult();
    }
    function catCDQL()
    {
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Produit a where a.idCategorie=5");


        return $query->getResult();
    }
    function catMDQL()
    {
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Produit a where a.idCategorie=7");


        return $query->getResult();
    }

    function findparamDQL($membre)
    {
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Produit a where a.idmembre=:membre")
            ->setParameter('membre',$membre);

        return $query->getResult();
    }

    function findNom($emp)
    {
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Produit a where a.nom=:emp")
            ->setParameter('emp',$emp);

        return $query->getResult();
    }

    function findempDQL($emp)
    {
        $query=$this->getEntityManager()->createQuery("select a from  EshopUserBundle:Publicite a where a.emp=:emp")
            ->setParameter('emp',$emp);

        return $query->getResult();
    }
    function findDQL($membre)
    {
        $query=$this->getEntityManager()->createQuery("select a from EshopUserBundle:Publicite a where a.idMembre=:membre")
            ->setParameter('membre',$membre);

        return $query->getResult();
    }


}