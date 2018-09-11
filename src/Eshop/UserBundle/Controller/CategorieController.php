<?php

namespace Eshop\UserBundle\Controller;
use Eshop\UserBundle\Entity\Categorie;
use Eshop\UserBundle\EshopUserBundle;
use Eshop\UserBundle\form\form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{

    function SupprimerAction($id){
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository("EshopUserBundle:Categorie")->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('eshop_user_afficher');

    }

    function afficherAction(){
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Default:cat.html.twig",array("categories"=>$categories));
    }
    function afficheradminAction(){
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Categorie:afficher.html.twig",array("categories"=>$categories));
    }

    function Ajout2Action(Request $request){
        $categorie=new categorie();
        $Form=$this->createForm(form::class,$categorie);
        $Form->handleRequest($request);
        if($Form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $categories=$em->getRepository("EshopUserBundle:Categorie")->findBynomcat($Form->get('nomcat')->getData());
            if($categories == null){

            $em->persist($categorie);
            $em->flush();
            return$this->redirectToRoute('eshop_user_afficher');
        }
        else{
            echo "<script>alert(\"Cette categorie existe déja\")</script>";

        }
        }
        return $this->render('EshopUserBundle:Categorie:ajout2.html.twig',
            array('forme'=>$Form->createView()));
    }

    function modifierAction($id, Request $request){
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository("EshopUserBundle:Categorie")->find($id);
        $Form=$this->createForm(form::class,$categorie);
        $Form->handleRequest($request);
        if($Form->isValid()){
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('eshop_user_afficher');
        } return $this->render("EshopUserBundle:Categorie:modif.html.twig",
            array('form'=>$Form->createView()));
    }
}
