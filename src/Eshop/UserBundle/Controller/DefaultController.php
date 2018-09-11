<?php

namespace Eshop\UserBundle\Controller;

use Eshop\UserBundle\Entity\Note;
use Eshop\UserBundle\Entity\Produit;
use Eshop\UserBundle\Entity\Publicite;
use Eshop\UserBundle\form\UserType;
use Eshop\UserBundle\form\ProductType;
use Eshop\UserBundle\form\rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $em=$this->getDoctrine()->getManager();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle:Default:index.html.twig",array("deals"=>$deals,"categories"=>$categories));
    }
    public function index2Action()
    {

        $em=$this->getDoctrine()->getManager();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render('EshopUserBundle:Default:index2.html.twig',array("deals"=>$deals,"categories"=>$categories));
    }
    public function adminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $utilisateur=$em->getRepository("EshopUserBundle:User")->find($user);
        return $this->render('EshopUserBundle:Default:admin.html.twig',array("deals"=>$deals,"categories"=>$categories));
    }
    public function accueilAction(Request $request)
    {


        $em=$this->getDoctrine()->getManager();
        //aymen
        $d= new \DateTime("now");
       $promo = $em->getRepository("EshopUserBundle:Produit")->findByEnPromotionDQL();
        $catv = $em->getRepository("EshopUserBundle:Produit")->catVDQL();
        $catc = $em->getRepository("EshopUserBundle:Produit")->catCDQL();
        $catm = $em->getRepository("EshopUserBundle:Produit")->catMDQL();
        $catt = $em->getRepository("EshopUserBundle:Produit")->catTDQL();

        $pub = $em->getRepository("EshopUserBundle:Publicite")->findALl();

        // $t = false;

        foreach ($pub as $p) {
            if (($d >= $p->getDated()) and ($d <= $p->getDatef())) {
                $pp = $em->getRepository("EshopUserBundle:Publicite")->find($p->getId());
                //    break;
            }


                        else
                        {
                            $pp= $em->getRepository("EshopUserBundle:Publicite")->find($p->getId());
                            $pp->setPhoto('zara.jpg');


                        }

        }

//saliim


        $echange=$em->getRepository('EshopUserBundle:Echange')->findAll();

       // $query = $em->createQuery("select v from EshopUserBundle:Echange v   ");

      //  $users = $query->getResult();


       // $paginator  = $this->get('knp_paginator');
      //  $pagination = $paginator->paginate(
        //    $users,
          //  $request->query->getInt('page', 1), /*page number*/
          //  5 /*limit per page*/
      //  );

        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $produit=$em->getRepository('EshopUserBundle:Produit')->findAll();

        return $this->render('EshopUserBundle:Default:aymen.html.twig',array("deals"=>$deals,"categories"=>$categories,"produits" => $produit, "promo" => $promo, "cat" => $catv, "catc" => $catc
        , "catm" => $catm, "catt" => $catt,"echange"=>$echange,"pub"=>$pp));
    }

    function detailAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $nte = new Note();
        $Form = $this->createForm(rating::class, $nte);
       $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {

           $em->persist($nte);
           $em->flush();
        }
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        $produit = $em->getRepository("EshopUserBundle:Produit")->find($id);


        return $this->render("EshopUserBundle:Default:detail.html.twig",array('produit'=>$produit,'form'=>$Form->createView(),"categories"=>$categories));
        //return $this->render("EshopUserBundle:Default:detail.html.twig",array('produit'=>$produit,"categories"=>$categories));
    }
public function pdfAction($id){
    $em=$this->getDoctrine()->getManager();
    $deals=$em->getRepository("EshopUserBundle:Deal")->find($id);
    $html = $this->renderView('@EshopUser/Default/pdf.html.twig', array(
        'deals'  => $deals
    ));

    return new Response(
        $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
        200,
        array(
            'Content-Type'          => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="deal.pdf"'
        )
    );




}
    public function accAction()
    {

        $em=$this->getDoctrine()->getManager();
        $deals=$em->getRepository("EshopUserBundle:Deal")->findAll();
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        return $this->render("EshopUserBundle::membrelayout.html.twig",array("deals"=>$deals,"categories"=>$categories));
    }

    public function profilAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $user=$this->getUser();
        $utilisateur=$em->getRepository("EshopUserBundle:user")->find($user);

     //   $form = $this->createForm(UserType::class, $utilisateur);
       // $form->handleRequest($request);
        $adresse = $utilisateur->getAdresse();
        if ($adresse="Nabeul") {
            $Latitudes = "36.7278251";
            $Longitudes = "10.709786699999995";
        }
        else if ($adresse="Sousse")
        {
            $Latitudes = "35.825603";
            $Longitudes = "10.608394999999973";
        }
        else if ($adresse="Tunis")
        {
            $Latitudes = "36.8064948";
            $Longitudes = "10.181531599999971";
        }
        else if ($adresse="Bizerte")
        {
            $Latitudes = "37.2746124";
            $Longitudes = "9.862724299999968";
        }

        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();


/*
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file
            $file = $utilisateur->getPath();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $utilisateur->setPath($fileName);
            $em->persist($utilisateur);
            $em->flush();
        }
        */
     //   return $this->render("EshopUserBundle:Default:profil.html.twig",array("user"=>$utilisateur,'form' => $form->createView(),"Latitudes"=>$Latitudes,"Longitudes"=>$Longitudes));
        return $this->render("EshopUserBundle:Default:profil.html.twig",array("user"=>$utilisateur,"Latitudes"=>$Latitudes,"Longitudes"=>$Longitudes,"categories"=>$categories));
    }

    function afficherAction()
    {
        $user=$this->getUser();

        $em=$this->getDoctrine()->getManager();
        $produits=$em->getRepository("EshopUserBundle:Produit")->findparamDQL($user);
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        // $produits->setPrixP(($produits->getPromo()*$produits->getPrix())/100);




        return $this->render("EshopUserBundle:Default:produits.html.twig",array("produit"=>$produits,"categories"=>$categories));
    }

    function UpdateAction($id,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        $user=$em->getRepository("EshopUserBundle:User")->find($id);
        $Form=$this->createForm(UserType::class,$user);
        $Form->handleRequest($request);
        if($Form->isSubmitted() &&$Form->isValid())
        {
            $file = $user->getPath();
            $fileName = $file->getClientOriginalName();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $user->setPath($fileName);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("esprit_profil");

        }
        return $this->render("EshopUserBundle:Default:modifP.html.twig",array('form'=>$Form->createView(),"categories"=>$categories));
    }

    function ajoutAction(Request $request)
    {
        $produit=new Produit();
        $Form=$this->createForm(ProductType::class,$produit);
        $em=$this->getDoctrine()->getManager();


        $Form->handleRequest($request);
        if ($Form->isValid()){

            $user=$this->getUser();
            $id=$produit->getIdCategorie();

            $categorie=$em->getRepository("EshopUserBundle:Categorie")->find($id);

            $produit->setIdCategorie($categorie);

            $produit->setIdMembre($user);
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $produit->getPhoto();

            $fileName = $file->getClientOriginalName();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $produit->setPhoto($fileName);
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute("esprit_produit");
        }

        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        return $this->render('EshopUserBundle:Default:ajout.html.twig',array('form'=>$Form->createView(),"categories"=>$categories));

    }

    function empAction($id)
    {


        $user=$this->getUser();
        return $this->render("EshopUserBundle:Default:emplacement1.html.twig",array('user'=>$user));
    }

    function SuppAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("EshopUserBundle:Produit")->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("esprit_produit");
    }


    function modifpAction($id,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("EshopUserBundle:Produit")->find($id);
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        $Form=$this->createForm(ProductType::class,$produit);
        $Form->handleRequest($request);
        if($Form->isSubmitted() &&$Form->isValid())
        {


            $file = $produit->getPhoto();

            $fileName = $file->getClientOriginalName();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $produit->setPhoto($fileName);

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute("esprit_produit");

        }
        return $this->render("EshopUserBundle:Default:modifProduit.html.twig",array('form'=>$Form->createView(),"categories"=>$categories));
    }

    public function promoAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $produit=$em->getRepository("EshopUserBundle:Produit")->find($id);
        if($request->isMethod('POST'))
        {
            $produit->setPrixP($request->get('prixP'));
            $produit->setPromo($request->get('promo'));

            $produit->setEnpromotion('1');
            $em->persist($produit);

            $em->flush();

            return $this->redirectToRoute("esprit_produit");
        }



        return $this->render('EshopUserBundle:Default:promo.html.twig',array("produit"=>$produit,"categories"=>$categories));
    }

    function rechDQLAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
      //  $nte = new Note();
      //  $Form = $this->createForm(rating::class, $nte);
       // $Form->handleRequest($request);
       // if ($Form->isSubmitted() && $Form->isValid()) {

         //   $em->persist($nte);
          //  $em->flush();




       // }


        if($request->isMethod('post'))
        {

            $nom=$request->get("nom");
            if($nom !="") {
                $produit = $em->getRepository("EshopUserBundle:Produit")->findNom($nom);
                return $this->render("EshopUserBundle:Default:rech.html.twig", array('produit' => $produit,"categories"=>$categories));
            }
            {

                $produit=$em->getRepository("EshopUserBundle:Produit")->findAll();
            }

        }

     //  return $this->render("EshopUserBundle:Default:rech.html.twig",array('produit'=>$produit,'form'=>$Form->createView(),"categories"=>$categories));
        return $this->render("EshopUserBundle:Default:rech.html.twig",array('produit'=>$produit,"categories"=>$categories));
    }

    function catalogueAction()
    {

        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        $produit=$em->getRepository("EshopUserBundle:Produit")->findAll();



        return $this->render("EshopUserBundle:Default:catalogue.html.twig",array('produit'=>$produit,"categories"=>$categories));
    }

    function admin2Action()
    {
        $em=$this->getDoctrine()->getManager();

        $user=$this->getUser();
        $utilisateur=$em->getRepository("EshopUserBundle:user")->find($user);
        $produit=$em->getRepository("EshopUserBundle:Produit")->findAll();

        return $this->render("EshopUserBundle:Default:admin2.html.twig",array('user'=>$utilisateur,'produit'=>$produit));

    }
    function allpubAction()
    {


        $em=$this->getDoctrine()->getManager();

        $user=$this->getUser();

        $pub=$em->getRepository("EshopUserBundle:Publicite")->findAll();



        return $this->render("EshopUserBundle:Default:adminp.html.twig",array('publicite'=>$pub));



    }

    function suppAAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("EshopUserBundle:Produit")->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("esprit_admin");

    }

    function pubAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $pub = new Publicite();
        $Form=$this->createForm(\Eshop\UserBundle\form\pubType::class,$pub);
        $Form->handleRequest($request);
        $user=$em->getRepository("EshopUserBundle:User")->find($id);
        $pub1 = $em->getRepository("EshopUserBundle:Publicite")->findempDQL($pub->getEmp());

        if($Form->isSubmitted() &&$Form->isValid())
        {
            $user1=$this->getUser();
            //   $p=$em->getRepository("EspritBundle:Publicite")->findDQL($user1->getId());


            $pub->setIdMembre($user1);
            $interval = date_diff($pub->getDated(), $pub->getDatef());
            $pub->setPrix(($interval->format('%a')+1)*$pub->getEmp()) ;
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $pub->getPhoto();
            $pub->setEmp(20);
            $fileName = $file->getClientOriginalName();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $pub->setPhoto($fileName);
            $pub->setNom($user->getNom());

            if($pub->getDated()>$pub->getDatef()) {
                echo '<script language="javascript">';
                echo 'alert("Veulliez choisir une autre date")';
                echo '</script>';
            }
            else {


                if ($pub1 == null) {
                    $em->persist($pub);
                    $em->flush();
                    return $this->redirectToRoute("esprit_erreur");
                }
                else{

                    $pub11 = $em->getRepository("EshopUserBundle:Publicite")->findempDQL($pub->getEmp());
                    foreach ($pub11 as $p) {

                        /*test date */  $isBetween = (($pub->getDated() >= $p->getDated()) and ($pub->getDated() <= $p->getDatef()))
                        or (($pub->getDatef() >= $p->getDated()) and ($pub->getDatef() <= $p->getDatef())) ;
                        if ($isBetween) {
                            break ;
                        }}


                    if ($isBetween == false)
                    {
                        $em->persist($pub);
                        $em->flush();
                        return $this->redirectToRoute("esprit_erreur");

                    }
                    else {
                        echo '<script language="javascript">';
                        echo 'alert("Veulliez choisir une autre date")';
                        echo '</script>';

                    }

                }
            }
        }


        return $this->render("EshopUserBundle:Default:pub.html.twig",array('form'=>$Form->createView(),"categories"=>$categories));

    }

    function erreurAction()
    {

        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        $user=$this->getUser();
        $produit=$em->getRepository("EshopUserBundle:Publicite")->findDQL($user);
        return $this->render("EshopUserBundle:Default:erreur.html.twig",array('pub'=>$produit,"categories"=>$categories));
    }


}
