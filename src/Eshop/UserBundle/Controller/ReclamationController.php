<?php

namespace Eshop\UserBundle\Controller;

use Eshop\UserBundle\Entity\Echange;
use Eshop\UserBundle\Entity\Reclamation;
use Eshop\UserBundle\Entity\User;
use Eshop\UserBundle\EshopUserBundle;
use Eshop\UserBundle\Repository\ReclamationRepository;
use Eshop\UserBundle\form\Ajoutrecform;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ReclamationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }






    function AfficherecAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $reclamations = $em->getRepository('EshopUserBundle:Reclamation')->findAll();
        $paginator  = $this->get('knp_paginator');
        $blogPosts = $paginator->paginate(
            $reclamations,
            $request->query->getInt('page', 1),
       5
        );

       $count=$em->getRepository(Reclamation::class)->CalculNbRec();

        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        return $this->render('EshopUserBundle:Reclamation:afficherecl.html.twig', array('reclamation' => $blogPosts,'count'=>$count,"categories"=>$categories));

        }



    function findMotifAction($motif)
    {
        $em=$this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('EshopUserBundle:Reclamation');
        $reclamations=$em->getRepository(Reclamation::class)->findparamDQL($motif);

        return $this->render("EshopUserBundle:Reclamation:Traitementrec.html.twig",array("reclamation"=>$reclamations));

    }

    function SuppAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();

        // $em2=$this->getDoctrine()->getManager();
        $reclamation = $em->getRepository('EshopUserBundle:Reclamation')->findAll();
        $count = $em->getRepository(Reclamation::class)->CalculNbRec();

return $this->redirectToRoute('eshop_admin_reclamations');
         }



    function Ajout2Action(Request $request)
    {

        $reclamation=new Reclamation();
        //$reclamation->setUser($this->getUser());
        $reclamation->setIdm($this->getUser());
        $Form=$this->createForm(Ajoutrecform::class,$reclamation);
        $Form->handleRequest($request);
        if ($Form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Reclamation insérée avec succès !'
            );

        }
        $em2=$this->getDoctrine()->getManager();
        $categories=$em2->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Reclamation:Reclamation.html.twig",array('form'=>$Form->createView(),"categories"=>$categories));
    }











   function UpdateAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $reclamation->setEtat('Traité');

            $em->persist($reclamation);
            $em->flush();
        $em2=$this->getDoctrine()->getManager();
        $reclamation=$em2->getRepository('EshopUserBundle:Reclamation')->findAll();
        $count=$em2->getRepository(Reclamation::class)->CalculNbRec();
        return $this->redirectToRoute('eshop_admin_reclamations');
    }






}
