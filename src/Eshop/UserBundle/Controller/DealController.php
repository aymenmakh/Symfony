<?php
/**
 * Created by PhpStorm.
 * User: KALLEL
 * Date: 02/04/2017
 * Time: 20:35
 */

namespace Eshop\UserBundle\Controller;

use Eshop\UserBundle\Entity\Deal;
use Eshop\UserBundle\EshopUserBundle;
use Eshop\UserBundle\form\DealForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class DealController extends Controller
{
    function afficheradminAction(){
        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT d
    FROM EshopUserBundle:Deal d
    WHERE d.dateExpiration >=d.dateemition
   '
        );
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();
        return $this->render("EshopUserBundle:Deal:afficherdeal.html.twig",array("deals"=>$deals));
    }

    function SupprimeradminAction($id){
        $em=$this->getDoctrine()->getManager();
        $deal=$em->getRepository("EshopUserBundle:Deal")->find($id);
        $em->remove($deal);
        $em->flush();
        return $this->redirectToRoute('eshop_user_afficherdeal');

    }
    function afficherAction(){

        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT d
    FROM EshopUserBundle:Deal d
    WHERE d.dateExpiration >=d.dateemition
   '
        );
        $deals = $query->getResult();
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Deal:afficherdeale.html.twig",array("deals"=>$deals,"categories"=>$categories));
    }
    function SupprimerAction($id){
        $em=$this->getDoctrine()->getManager();
        $deal=$em->getRepository("EshopUserBundle:Deal")->find($id);
        $em->remove($deal);
        $em->flush();
        return $this->redirectToRoute('eshop_mesdeale');

    }
    function Ajout22Action(Request $request){
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $deal=new deal();
        $Form=$this->createForm(DealForm::class,$deal);
        $Form->handleRequest($request);
        if($Form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $deal->setIdEntreprise($this->getUser());
            $deal->setDateemition(new \DateTime());
            $em->persist($deal);
            $em->flush();


            return$this->redirectToRoute('eshop_user_afficherdeale');
        }

        return $this->render('EshopUserBundle:Deal:ajout22.html.twig',
            array('forme'=>$Form->createView(),"categories"=>$categories,"deals"=>$deal));
    }

    function modifier1Action($id, Request $request){
        $em=$this->getDoctrine()->getManager();
        $deal=$em->getRepository("EshopUserBundle:Deal")->find($id);
        $Form=$this->createForm(DealForm::class,$deal);
        $Form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();

        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        if($Form->isValid()){
           $exp= $Form->get('dateExpiration')->getData();


            $deal->setIdEntreprise($this->getUser());
            $deal->setDateemition(new \DateTime());
            if ($exp > new \DateTime()){
            $em->persist($deal);
            $em->flush();
            return $this->redirectToRoute('eshop_mesdeale');
        } } return $this->render("EshopUserBundle:Deal:modif1.html.twig",
            array('form'=>$Form->createView(),"categories" => $categories));
    }
    function mesdealsAction(){
        $em=$this->getDoctrine()->getManager();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findByidEntreprise($this->getUser());
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Deal:mesdeale.html.twig",array("deals"=>$deals,"categories"=>$categories));
    }
    function affichermAction(){
        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT d
    FROM EshopUserBundle:Deal d
    WHERE d.dateExpiration >=d.dateemition
   '
        );
        $deals = $query->getResult();
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Deal:afficherdealm.html.twig",array("deals"=>$deals,"categories"=>$categories));
    }

    function detailAction($id){
        $em=$this->getDoctrine()->getManager();
        $deals=$em->getRepository("EshopUserBundle:Deal")->find($id);
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Deal:detailsdeal.html.twig",array("deals"=>$deals,"categories"=>$categories));
    }
    function detailmAction($id){
        $em=$this->getDoctrine()->getManager();
        $deals=$em->getRepository("EshopUserBundle:Deal")->find($id);
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Deal:detailsdealm.html.twig",array("deals"=>$deals,"categories"=>$categories));
    }
}
