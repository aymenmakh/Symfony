<?php

namespace Eshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function facturesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        $factures = $em->getRepository('EshopUserBundle:Commandes')->byFacture($this->getUser());
        $paginator = $this->get('knp_paginator');
        $result = $pagination = $paginator->paginate(
            $factures, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('@EshopUser/Default/facture.html.twig', array('factures' => $result,"categories"=>$categories));
    }

    public function pdfAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('EshopUserBundle:Commandes')->find($id);
        $html = $this->renderView('@EshopUser/Default/pdf.html.twig', array(
            'commande'  => $commande
        ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="commande.pdf"'
            )
        );

    }
}

