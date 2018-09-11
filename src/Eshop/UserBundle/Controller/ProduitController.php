<?php

namespace Eshop\UserBundle\Controller;
/*
use EspritBundle\Entity\Note;
use EspritBundle\Entity\Product;
use EspritBundle\Entity\Produit;
use EspritBundle\Entity\User;
use EspritBundle\Entity\Categorie;
use EspritBundle\Entity\Publicite;
use EspritBundle\Form\ProductType;
use EspritBundle\Form\promo1Type;
use EspritBundle\Form\PromoType;
use EspritBundle\Form\pub102;
use EspritBundle\Form\pub10type;
use EspritBundle\Form\pub15type;
use EspritBundle\Form\pubType;
use EspritBundle\Form\rating;
use EspritBundle\Form\rechType;
use EspritBundle\Form\UserType;
*/
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;




class ProduitController extends Controller
{
    public function profilAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $user=$this->getUser();
        $utilisateur=$em->getRepository("EspritBundle:user")->find($user);

        $form = $this->createForm(UserType::class, $utilisateur);
        $form->handleRequest($request);
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



        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $utilisateur->getPath();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $utilisateur->setPath($fileName);
            $em->persist($utilisateur);
            $em->flush();
        }
        return $this->render("EspritBundle:Default:profil.html.twig",array("user"=>$utilisateur,'form' => $form->createView(),"Latitudes"=>$Latitudes,"Longitudes"=>$Longitudes));
    }



    public function promoAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("EspritBundle:Produit")->find($id);
        if($request->isMethod('POST'))
        {
            $produit->setPrixP($request->get('prixP'));
            $produit->setPromo($request->get('promo'));

            $produit->setEnpromotion('1');
            $em->persist($produit);

            $em->flush();

            return $this->redirectToRoute("esprit_produit");
        }



        return $this->render('EspritBundle:Default:promo.html.twig',array("produit"=>$produit));
    }





    public function internauteAction()
    {
        $em = $this->getDoctrine()->getManager();
        //  $cat= $em->getRepository("EspritBundle:Produit")->findAll();
        $user = $em->getRepository("EspritBundle:User")->findAll();
        //$promo = $em->getRepository("EspritBundle:Produit")->findByEnPromotionDQL();
        return $this->render('EspritBundle:Default:internaute.html.twig',array('user'=>$user));
    }

    public function produitAction()
    {
        return $this->render('EspritBundle:Default:produits.html.twig');
    }
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("EspritBundle:Produit")->findAll();
        $promo = $em->getRepository("EspritBundle:Produit")->findByEnPromotionDQL();
        $catv = $em->getRepository("EspritBundle:Produit")->catVDQL();
        $catc = $em->getRepository("EspritBundle:Produit")->catCDQL();
        $catm = $em->getRepository("EspritBundle:Produit")->catMDQL();
        $catt = $em->getRepository("EspritBundle:Produit")->catTDQL();
        //   $datetime = date("Y-m-d");
        $d= new \DateTime("now");
        // $user=$this->getUser();
        $pub = $em->getRepository("EspritBundle:Publicite")->findALl();

        // $t = false;
        foreach ($pub as $p) {
            //   if (($d >= $p->getDated()) and ($d <= $p->getDatef())) {
            $pp= $em->getRepository("EspritBundle:Publicite")->find($p->getId());
            //    break;
            //  }
            /*
                        else
                        {
                            $pp= $em->getRepository("EspritBundle:Publicite")->find($p->getId());
                            $pp->setPhoto('zara.png');


                        }
            */
        }
        // if ($t == true) {

        return $this->render('EshopUserBundle::membrelayout.html.twig', array("produit" => $produit, "promo" => $promo, "cat" => $catv, "catc" => $catc
        , "catm" => $catm, "catt" => $catt,"pub"=>$pp));
        //}
        //else
        //  {return $this->render('EspritBundle:Default:index2.html.twig', array("produit" => $produit, "promo" => $promo, "cat" => $catv, "catc" => $catc
        //, "catm" => $catm, "catt" => $catt));}
    }
    function afficherAction()
    {
        $user=$this->getUser();

        $em=$this->getDoctrine()->getManager();
        $produits=$em->getRepository("EspritBundle:Produit")->findparamDQL($user);
        // $produits->setPrixP(($produits->getPromo()*$produits->getPrix())/100);




        return $this->render("EspritBundle:Default:produits.html.twig",array("produit"=>$produits));
    }

    function afficherMAction()
    {
        $em=$this->getDoctrine()->getManager();

        $user = $this->container->get('security.context')->getToken()->getUser();
        $utilisateur=$em->getRepository("EspritBundle:user")->find($user);
        return $this->render("EspritBundle:Default:profil.html.twig",array("user"=>$utilisateur));
    }

    function SuppAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("EspritBundle:Produit")->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("esprit_produit");
    }
    function ajoutAction(Request $request)
    {
        $produit=new Produit();
        $Form=$this->createForm(ProductType::class,$produit);

        $Form->handleRequest($request);
        if ($Form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $user=$this->getUser();
            $id=$produit->getIdcat();

            $categorie=$em->getRepository("EspritBundle:Categorie")->find($id);

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


        return $this->render('EspritBundle:Default:ajout.html.twig',array('form'=>$Form->createView()));

    }
    function UpdateAction($id,Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        $user=$em->getRepository("EspritBundle:User")->find($id);
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
        return $this->render("EspritBundle:Default:modifP.html.twig",array('form'=>$Form->createView()));
    }

    function adminAction()
    {
        $em=$this->getDoctrine()->getManager();

        $user=$this->getUser();
        $utilisateur=$em->getRepository("EspritBundle:user")->find($user);
        $produit=$em->getRepository("EspritBundle:Produit")->findAll();



        return $this->render("EspritBundle:Default:admin.html.twig",array('user'=>$utilisateur,'produit'=>$produit));

    }

    function pubAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();

        $pub = new Publicite();
        $Form=$this->createForm(pubType::class,$pub);
        $Form->handleRequest($request);
        $user=$em->getRepository("EspritBundle:User")->find($id);
        $pub1 = $em->getRepository("EspritBundle:Publicite")->findempDQL($pub->getEmp());

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

                    $pub11 = $em->getRepository("EspritBundle:Publicite")->findempDQL($pub->getEmp());
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


        return $this->render("EspritBundle:Default:pub.html.twig",array('form'=>$Form->createView()));

    }
    function modifpAction($id,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("EspritBundle:Produit")->find($id);

        $Form=$this->createForm(ProductType::class,$produit);
        $Form->handleRequest($request);
        if($Form->isSubmitted() &&$Form->isValid())
        {

            /*
            $file = $produit->getPhoto();

            $fileName = $file->getClientOriginalName();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $produit->setPhoto($fileName);
*/
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute("esprit_produit");

        }
        return $this->render("EspritBundle:Default:modifProduit.html.twig",array('form'=>$Form->createView()));
    }


    function empAction($id)
    {


        $user=$this->getUser();
        return $this->render("EspritBundle:Default:emplacement1.html.twig",array('user'=>$user));
    }


    function erreurAction()
    {

        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $produit=$em->getRepository("EspritBundle:Publicite")->findDQL($user);
        return $this->render("EspritBundle:Default:erreur.html.twig",array('pub'=>$produit));
    }

    function mapAction()
    {

        $Latitudes= "-24";
        $Longitudes = "142";

        return $this->render("EspritBundle:Default:map.html.twig",array('Latitudes'=>$Latitudes,'Longitudes'=>$Longitudes));
    }

    function catalogueAction()
    {

        $em=$this->getDoctrine()->getManager();


        $produit=$em->getRepository("EspritBundle:Produit")->findAll();



        return $this->render("EspritBundle:Default:catalogue.html.twig",array('produit'=>$produit));
    }

    function rechDQLAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nte = new Note();
        $Form = $this->createForm(rating::class, $nte);
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {

            $em->persist($nte);
            $em->flush();




        }


        if($request->isMethod('post'))
        {

            $nom=$request->get("nom");
            if($nom !="") {
                $produit = $em->getRepository("EspritBundle:Produit")->findNom($nom);
                return $this->render("EspritBundle:Default:rech.html.twig", array('produit' => $produit));
            }
            if ($request->get("nom")== "")
            {
                $produit=$em->getRepository("EspritBundle:Produit")->findAll();
            }

        }

        return $this->render("EspritBundle:Default:rech.html.twig",array('produit'=>$produit,'form'=>$Form->createView()));
    }
    function suppAAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("EspritBundle:Produit")->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("E");

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

        $produit = $em->getRepository("EspritBundle:Produit")->find($id);


        return $this->render("EspritBundle:Default:detail.html.twig",array('produit'=>$produit,'form'=>$Form->createView()));
    }


    function pub102Action(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $pub = new Publicite();
        $Form = $this->createForm(pub102::class, $pub);
        $Form->handleRequest($request);
        $user = $em->getRepository("EspritBundle:User")->find($id);
        $pub1 = $em->getRepository("EspritBundle:Publicite")->findempDQL($pub->getEmp());

        if ($Form->isSubmitted() && $Form->isValid()) {
            $user1 = $this->getUser();
            //   $p=$em->getRepository("EspritBundle:Publicite")->findDQL($user1->getId());


            $pub->setIdMembre($user1);
            $interval = date_diff($pub->getDated(), $pub->getDatef());
            $pub->setPrix(($interval->format('%a') + 1) * $pub->getEmp());
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $pub->getPhoto();

            $fileName = $file->getClientOriginalName();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $pub->setPhoto($fileName);
            $pub->setNom($user->getNom());

            if ($pub->getDated() > $pub->getDatef()) {
                echo '<script language="javascript">';
                echo 'alert("Veulliez choisir une autre date")';
                echo '</script>';
            } else {


                if ($pub1 == null) {
                    $em->persist($pub);
                    $em->flush();
                    return $this->redirectToRoute("esprit_erreur");
                } else {

                    $pub11 = $em->getRepository("EspritBundle:Publicite")->findempDQL($pub->getEmp());
                    foreach ($pub11 as $p) {

                        /*test date */
                        $isBetween = (($pub->getDated() >= $p->getDated()) and ($pub->getDated() <= $p->getDatef()))
                        or (($pub->getDatef() >= $p->getDated()) and ($pub->getDatef() <= $p->getDatef()));
                        if ($isBetween) {
                            break;
                        }
                    }


                    if ($isBetween == false) {
                        $em->persist($pub);
                        $em->flush();
                        return $this->redirectToRoute("esprit_erreur");

                    } else {
                        echo '<script language="javascript">';
                        echo 'alert("Veulliez choisir une autre date")';
                        echo '</script>';

                    }

                }
            }
        }


        return $this->render("EspritBundle:Default:pub102.html.twig", array('form' => $Form->createView()));
    }
    function pub15Action(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $pub = new Publicite();
        $Form = $this->createForm(pub15type::class, $pub);
        $Form->handleRequest($request);
        $user = $em->getRepository("EspritBundle:User")->find($id);
        $pub1 = $em->getRepository("EspritBundle:Publicite")->findempDQL($pub->getEmp());

        if ($Form->isSubmitted() && $Form->isValid()) {
            $user1 = $this->getUser();
            //   $p=$em->getRepository("EspritBundle:Publicite")->findDQL($user1->getId());


            $pub->setIdMembre($user1);
            $interval = date_diff($pub->getDated(), $pub->getDatef());
            $pub->setPrix(($interval->format('%a') + 1) * $pub->getEmp());
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $pub->getPhoto();

            $fileName = $file->getClientOriginalName();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $pub->setPhoto($fileName);
            $pub->setNom($user->getNom());

            if ($pub->getDated() > $pub->getDatef()) {
                echo '<script language="javascript">';
                echo 'alert("Veulliez choisir une autre date")';
                echo '</script>';
            } else {


                if ($pub1 == null) {
                    $em->persist($pub);
                    $em->flush();
                    return $this->redirectToRoute("esprit_erreur");
                } else {

                    $pub11 = $em->getRepository("EspritBundle:Publicite")->findempDQL($pub->getEmp());
                    foreach ($pub11 as $p) {

                        /*test date */
                        $isBetween = (($pub->getDated() >= $p->getDated()) and ($pub->getDated() <= $p->getDatef()))
                        or (($pub->getDatef() >= $p->getDated()) and ($pub->getDatef() <= $p->getDatef()));
                        if ($isBetween) {
                            break;
                        }
                    }


                    if ($isBetween == false) {
                        $em->persist($pub);
                        $em->flush();
                        return $this->redirectToRoute("esprit_erreur");

                    } else {
                        echo '<script language="javascript">';
                        echo 'alert("Veulliez choisir une autre date")';
                        echo '</script>';

                    }

                }
            }
        }


        return $this->render("EspritBundle:Default:pub15.html.twig", array('form' => $Form->createView()));
    }

    function testAction()
    {


        $user=$this->getUser();
        return $this->render("EspritBundle::test.html.twig");
    }

    function profil1Action(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $user=$this->getUser();
        $utilisateur=$em->getRepository("EspritBundle:user")->find($user);
        //  $file = $utilisateur->getPath();
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        //  $fileName = $file->getClientOriginalName();
        //  $file->move(
        //     $this->getParameter('brochures_directory'),
        //     $fileName
        //  );
        // $utilisateur->setPhoto($fileName);

        $form = $this->createForm(UserType::class, $utilisateur);
        $form->handleRequest($request);
        $adresse = $utilisateur->getAdresse();
        if ($adresse=="Nabeul") {
            $Latitudes = "36.7278251";
            $Longitudes = "10.709786699999995";
        }
        else if ($adresse=="Sousse")
        {
            $Latitudes = "35.82";
            $Longitudes = "10.60";
        }
        else if ($adresse=="Tunis")
        {
            $Latitudes = "36.8064948";
            $Longitudes = "10.181531599999971";
        }
        else if ($adresse=="Bizerte")
        {
            $Latitudes = "37.2746124";
            $Longitudes = "9.862724299999968";
        }



        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $utilisateur->getPath();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $utilisateur->setPath($fileName);
            $em->persist($utilisateur);
            $em->flush();
        }
        return $this->render("EspritBundle:Default:profil1.html.twig",array("user"=>$utilisateur,'form' => $form->createView(),"Latitudes"=>$Latitudes,"Longitudes"=>$Longitudes));

    }

    function allpubAction()
    {


        $em=$this->getDoctrine()->getManager();

        $user=$this->getUser();

        $pub=$em->getRepository("EspritBundle:Publicite")->findAll();



        return $this->render("EspritBundle:Default:adminp.html.twig",array('publicite'=>$pub));



    }



}





