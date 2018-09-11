<?php

namespace Eshop\UserBundle\Controller;

use Eshop\UserBundle\Entity\Commandes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommandesController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    public function facture(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $adresse = $session->get('adresse');
        $commande = array();
        $panier = $session->get('panier');
        $totalHT = 0;
        $totalTTC = 0;
        $livraison = $em->getRepository('EshopUserBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $produits = $em->getRepository('EshopUserBundle:Produit')->findArray(array_keys($session->get('panier')));
        foreach($produits as $produit)
        {
            $prixHT = ($produit->getPrix() * $panier[$produit->getId()]);
            $prixTTC = ($produit->getPrix() * $panier[$produit->getId()]);
            $totalHT += $prixHT;
            $totalTTC += $prixTTC;



            $commande['produit'][$produit->getId()] = array('reference' => $produit->getNom(),
                'quantite' => $panier[$produit->getId()],
                'prixHT' => round($produit->getPrix()),
                'prixTTC' => round($produit->getPrix()),'photo' => $produit->getPhoto(), 'description' =>$produit->getDescription());
        }

        $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
            'nom' => $livraison->getNom(),
            'telephone' => $livraison->getTelephone(),
            'adresse' => $livraison->getAdresse(),
            'cp' => $livraison->getCp(),
            'ville' => $livraison->getVille(),
            'pays' => $livraison->getPays(),
            'complement' => $livraison->getComplement());
        $commande['prixHT'] = round($totalHT);
        $commande['prixTTC'] = round($totalTTC);

        return $commande;
    }

    public function prepareCommandeAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $commande = new Commandes();
        $commande->setDate(new \DateTime());
        $commande->setUtilisateur($this->getUser());
        $commande->setValider(1);
        $commande->setReference(0);
$commande->setCommande($this->facture($request));

        $em->persist($commande);
        $session->set('commande',$commande);

        $em->flush();

        return new Response($commande->getId());
    }

    public function annuleAction($id){
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('EshopUserBundle:Commandes')->find($id);
        $commande->setValider(0);
        $em->persist($commande);
        $em->flush();
return $this->redirectToRoute('factures');

    }
    public function afficheAction($id){
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('EshopUserBundle:Commandes')->find($id);
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();


        return $this->render("EshopUserBundle:Default:afficherfacture.html.twig",array("commande"=>$commande,"categories"=>$categories));

    }
}