<?php

namespace Eshop\UserBundle\Controller;


use Eshop\UserBundle\form\ajoutech;
use Eshop\UserBundle\form\proposerech;
use Eshop\UserBundle\Form\Recherche;
use Eshop\UserBundle\Repository\EchangeRepository;
use MyAppMailBundle\Form\MailType;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eshop\UserBundle\Entity\Echange;
use Eshop\UserBundle\Entity\Categorie;
use Eshop\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\FileUploader;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\HttpFoundation\Session;

class echangeController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    function AfficheechAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $echanges = $em->getRepository('EshopUserBundle:Echange')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $echanges,
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('EshopUserBundle:echange:adminaff.html.twig',array('echanges'=>$pagination));
        //array('echanges' => $pagination));

    }



    function AfficheEchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $moi= $this->getUser()->getId();

        // $query = $em->createQuery("select v from EshopUserBundle:Echange v WHERE v.e_id='$moi'");
        $query = $em->createQuery("select v from EshopUserBundle:Echange v WHERE v.e_id!=$moi  ");

        $users = $query->getResult();


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:echange:afficheechange.html.twig", array("echanges" => $pagination,"categories"=>$categories,"deals"=>$deals));

    }

    function mesProduitsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $moi = $this->getUser()->getId();
        $ech = $em->getRepository(Echange::class)->findAll();
        $query = $em->createQuery("select v from EshopUserBundle:Echange v WHERE v.e_id='$moi'");
        $users = $query->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();

        //  $count=$em2->getRepository(Reclamation::class)->CalculNbRec();
        return $this->render("EshopUserBundle:echange:moiechange.html.twig",array("echanges" => $pagination,"categories"=>$categories,"deals"=>$deals));

    }


    function AjoutechangeAction(Request $request)
    {

        $echange = new Echange();
        $echange->setEId($this->getUser());
        $Form = $this->createForm(ajoutech::class, $echange);
        $Form->handleRequest($request);
        //if ($form->isValid()) {


        if ($Form->isValid() && $Form->isSubmitted() && $echange->getPrix()>=$echange->getPrixMinimal()) {
            $echange->setDatefin(new \DateTime('now +30days'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($echange);
            $em->flush();
            return $this->redirectToRoute("eshop_membre_Affechange");
        }
        if ($Form->isValid() && $Form->isSubmitted() && $echange->getPrix()<$echange->getPrixMinimal() )
        {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'le prix doit être superieur ou égal au prix minimal !'
            );
        }
        $em3 = $this->getDoctrine()->getManager();
        $deals=$em3->getRepository("EshopUserBundle:Deal")->findAll();
        $em2 = $this->getDoctrine()->getManager();
        $categories=$em2->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:echange:echange.html.twig", array('form' => $Form->createView(),"categories"=>$categories,"deals"=>$deals));
    }





    function ProposerEchangeAction(Request $request, $idech)
    {
        $echange = new Echange();
        $echange->setEId($this->getUser());
        $Form = $this->createForm(proposerech::class, $echange);
        $Form->handleRequest($request);
        $echange->setPrixMinimal(0);
        $moi = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("select v from EshopUserBundle:Echange v WHERE v.id=$idech");
        $lui = $query->getScalarResult();

        $ech = $em->getRepository(Echange::class)->find($idech);
        $pr = $ech->getPrixMinimal();

        if ($Form->isValid() && $Form->isSubmitted() && $echange->getPrix() >= $pr )

        {

            $echange->setDatefin(new \DateTime('now +30days'));
            $echange->setEtat('');
            $em2 = $this->getDoctrine()->getManager();
            $em2->persist($echange);


            $em2->flush();
            //API:MAIL
            $myappContactMail = 'selim.mabroukk@gmail.com';
            $myappContactPassword = 'azertyuiop1994';
            //$email=$this->get('session')->getEmail();

            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
                ->setUsername($myappContactMail)
                ->setSourceIp('0.0.0.0')
                ->setPassword($myappContactPassword);
            $mailer = \Swift_Mailer::newInstance($transport);

            $message = \Swift_Message::newInstance("proposition échange ")
                ->setFrom(array($myappContactMail))
                ->setTo('salim.mabrouk@esprit.tn')
                ->setBody($this->renderView( '@EshopUser/Default/mail.html.twig',
                    array('echanges'=>$echange,$moi), 'text/html'));

            $mailer->send($message);

            return $this->redirectToRoute('eshop_membre_Affechange');
        }

        if ($echange->getPrix() < $pr )
        {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'prix insuffisant !'
            );

        }




        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();

        //pagination!!!!!!
        return $this->render("EshopUserBundle:echange:proposition.html.twig", array('form' => $Form->createView(),"categories"=>$categories,"deals"=>$deals));

    }


    function SupprimerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $echange=$em->getRepository("EshopUserBundle:Echange")->find($id);

        $em->remove($echange);
        $em->flush();

        return $this->redirectToRoute('eshop_aaadmin_echange');
    }
    function UpdateAction($idech,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository(Echange::class)->find($idech);
        $Form=$this->createForm(ajoutech::class,$modele);
        $Form->handleRequest($request);
        if($Form->isValid())
        {
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute("eshop_mesproduits");

        }
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();
        return $this->render("EshopUserBundle:echange:modEchange.html.twig",array('form'=>$Form->createView(),"categories"=>$categories,"deals"=>$deals));
    }













}