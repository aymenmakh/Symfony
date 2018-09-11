<?php

namespace Eshop\UserBundle\Controller;

use Eshop\UserBundle\Entity\Commandes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Commande controller.
 *
 */
class CommandesAdminController extends Controller
{
    /**
     * Lists all commande entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('EshopUserBundle:Commandes')->findAll();
        $paginator = $this->get('knp_paginator');
        $result = $pagination = $paginator->paginate(
            $commandes, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('commandes/index.html.twig', array(
            'commandes' => $result));
    }

    /**
     * Finds and displays a commande entity.
     *
     */
    public function showAction(Commandes $commande)
    {

        return $this->render('commandes/show.html.twig', array(
            'commande' => $commande,
        ));
    }
}
