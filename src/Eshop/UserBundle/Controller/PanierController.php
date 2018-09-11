<?php

namespace Eshop\UserBundle\Controller;
use Eshop\UserBundle\Entity\Produit;

use Eshop\UserBundle\Entity\UtilisateursAdresses;
use Eshop\UserBundle\form\UtilisateursAdressesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function menuAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EshopUserBundle:Produit')->findArray(array_keys($session->get('panier')));

        return $this->render('EshopUserBundle:Panier:nbr.html.twig', array('produits' => $produits,
            'panier' => $session->get('panier')));
    }
    public function ajouterAction($id, Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
            $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
        } else {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;

            $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
        }

        $session->set('panier',$panier);


        return $this->redirect($this->generateUrl('panier'));
    }
    public function panierAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EshopUserBundle:Produit')->findArray(array_keys($session->get('panier')));
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render('EshopUserBundle:Panier:panier.html.twig', array('produits' => $produits,
            'panier' => $session->get('panier'),"categories"=>$categories));
    }
    public function supprimerAction($id, Request $request)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('panier'));
    }
public function livraisonAction(Request $request){

    {
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EshopUserBundle:Produit')->findArray(array_keys($session->get('panier')));
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $repository = $this->getDoctrine()->getRepository('EshopUserBundle:UtilisateursAdresses');
        $adresse = $repository->findByUtilisateur($user);

        $entity = new UtilisateursAdresses();
        $form = $this->createForm(UtilisateursAdressesType::class, $entity);



            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity->setUtilisateur($user);
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('panier_livraison'));
                    }
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        return $this->render('EshopUserBundle:Panier:livraison.html.twig', array('utilisateur' => $adresse,
            'form' => $form->createView(),'produits' => $produits,
            'panier' => $session->get('panier'),"categories"=>$categories));
    }
}
    public function adresseSuppressionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EshopUserBundle:UtilisateursAdresses')->find($id);

        if ($this->get('security.token_storage')->getToken()->getUser() != $entity->getUtilisateur() || !$entity)
            return $this->redirect ($this->generateUrl ('panier_livraison'));

        $em->remove($entity);
        $em->flush();

        return $this->redirect ($this->generateUrl ('panier_livraison'));
    }

    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('adresse')) $session->set('adresse',array());
        $adresse = $session->get('adresse');

        if ($request->request->get('livraison') != null)
        {
            $adresse['livraison'] = $request->request->get('livraison');

        } else {
            return $this->redirect($this->generateUrl('validation'));
        }

        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }
    public function validationAction(Request $request)
    {
        if ($request->getMethod() == 'POST')
            $this->setLivraisonOnSession($request);

        $em = $this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        $prepareCommande = $this->forward('EshopUserBundle:Commandes:prepareCommande',array($request));
        $commande = $em->getRepository('EshopUserBundle:Commandes')->find($prepareCommande->getContent());


        return $this->render('@EshopUser/Panier/validation.html.twig', array('commande' => $commande,"categories"=>$categories
        ));
    }

}
