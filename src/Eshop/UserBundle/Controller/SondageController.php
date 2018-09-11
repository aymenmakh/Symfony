<?php

namespace Eshop\UserBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Eshop\UserBundle\Entity\Question;
use Eshop\UserBundle\Entity\Reponse;
use Eshop\UserBundle\Entity\Sondage;
use Eshop\UserBundle\Entity\Utils;
use Eshop\UserBundle\form\AddSondageParamsType;
use Eshop\UserBundle\form\AddSondageType;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Eshop\UserBundle\form\UpdateType;
use Eshop\UserBundle\form\RechercheSondage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SondageController extends Controller
{
    public function addparamsAction(Request $request){
        $util = new Utils();
        $form = $this->createForm(AddSondageParamsType::class, $util);
        $form->handleRequest($request);
        if (!($util->getNb()==0)){

            return $this->redirect($this->generateUrl('add_sondage', array('nb' => $util->getNb())), 301);
                    }

        return $this->render("EshopUserBundle:Sondage:afficher.html.twig", array('form' => $form->createView()));
    }
    public function AfficherAction(Request $request,$id){

       $em = $this->getDoctrine()->getManager();
             $sondage = new Sondage();
        $questionList= $em->getRepository("EshopUserBundle:Question")->findBySondage($id);//pour le affcihage de tous

             //   return $this->render("CompetitionAthleteBundle:Athlete:affichage.html.twig", array( 'athletes' => $alldata));
        $done= $em->getRepository("EshopUserBundle:Reponse")->findBy(array('idQuestion' =>$questionList[0]->getId() , 'idmembre' => $this->getUser()->getId()));
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();

        if($done==null){
            return $this->render("EshopUserBundle:Sondage:afficherSondage.html.twig",array( 'sondage' => $sondage,'questionList' => $questionList,'theid'=>$id,"categories"=>$categories));

        }else{
            $reponses=[];
            foreach ($questionList as $question){
            $reponse = $em->getRepository("EshopUserBundle:Reponse")->findBy(array('idQuestion' =>$question->getId() , 'idmembre' => $this->getUser()->getId()));
           $reponses[$question->getSujet()]=$reponse[0]->getReponse();
                dump($reponses);

            }
            return $this->render("EshopUserBundle:Sondage:afficherSondageBlocked.html.twig",array( 'sondage' => $sondage,'questionList' => $questionList,'theid'=>$id,'reponses'=>$reponses,"categories"=>$categories));

        }
    }
    public function addAction($nb,Request $request)
    {
        $sondage = new Sondage();
        $a = new ArrayCollection();
        for ($x = 1; $x <= $nb; $x++) {
            $q = new Question();
            $q->setSondage($sondage);
           $a->add($q);
        }
        $sondage->setQuestions($a);
        $form = $this->createForm(AddSondageType::class, $sondage);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $sondage->setIdAdmin($user);
            $sondage->setRcounter(0);
            $em->persist($sondage);
            $em->flush();
          return $this->redirectToRoute('List_sondages_Afficher_back_Office');
        }

        return $this->render("EshopUserBundle:Sondage:add.html.twig", array('form' => $form->createView()));
    }
    public function updateAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
$sondage=new Sondage();
        $a = new ArrayCollection();
        $sondage=$em->getRepository("EshopUserBundle:Sondage")->find($id);
        $questions=$em->getRepository("EshopUserBundle:Question")->findBy(['sondage'=>$id]);
        $sondage->setQuestions($questions);

        $form = $this->createForm(UpdateType::class, $sondage);
        $form->handleRequest($request);
        if ($form->isValid()){
            foreach ($questions as $value){
        $value->setSondage($sondage);
    }
    $sondage->setQuestions($questions);
            $user = $this->getUser();
            $sondage->setIdAdmin($user);
            dump($sondage);
            $em->persist($sondage);
            $em->flush();
            //    return $this->redirectToRoute('Event_show');
            return $this->redirectToRoute('List_sondages_Afficher_back_Office');

        }

        return $this->render("EshopUserBundle:Sondage:update.html.twig", array('form' => $form->createView()));
    }
    public function index2Action()
    {
        return $this->render('EshopUserBundle:Default:index2.html.twig');
    }
    public function adminAction()
    {
        return $this->render('EshopUserBundle:Default:admin.html.twig');
    }
    public function accueilAction()
    {
        return $this->render('EshopUserBundle:Default:index.html.twig');
    }
    public function SubmitSondageAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
      //  $realrequest=$request->getRequest();


        $questionList= $em->getRepository("EshopUserBundle:Question")->findBySondage($request->get('sid'));

        $sondagex= $em->getRepository("EshopUserBundle:Sondage")->find($request->get('sid'));//pour le affcihage de tous
        //$sondagex->setId($id);
        if($sondagex->getRcounter()!=null){
            $sondagex->setRcounter($sondagex->getRcounter()+1);
        }else{
            $sondagex->setRcounter(1);
        }

        $em->persist($sondagex);
        $em->flush();
        foreach ($questionList as $value)
        {
            $reponse = new Reponse();
            $date = new \DateTime;
            $reponse->setDate($date);
            $user = $this->getUser();
            $reponse->setIdmembre($user);
            $reponse->setIdQuestion($value);
            $reponse->setReponse($request->get("x".$value->getId()));
            $em->persist($reponse);
            $em->flush();


        }
        return $this->redirectToRoute('List_sondages_Afficher_front_Office');
    //  if ($request->getMethod()=='POST'){
      //    $em = $this->getDoctrine()->getManager();
     //     $em->persist($reponse);
       //   $em->flush();

         //   return $this->redirectToRoute('task_success');
      //  }


        //return $this->redirectToRoute('task_success');
    }

    public function AfficherAdminAction(Request $request,$id){

        $em = $this->getDoctrine()->getManager();
        $sondage = new Sondage();
        $sondage= $em->getRepository("EshopUserBundle:Sondage")->findById($id);//pour le affcihage de tous
        $questionList= $em->getRepository("EshopUserBundle:Question")->findBySondage($id);//pour le affcihage de tous

        dump($questionList);
        return $this->render("EshopUserBundle:Sondage:afficherSondageAdmin.html.twig",array( 'sondage' => $sondage[0],'questionList' => $questionList));
    }
    public function SondageListBackOfficeAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $sondages= $em->getRepository("EshopUserBundle:Sondage")->findAll();//pour le affcihage de tous

        //$v = $em->getRepository("CompetitionAthleteBundle:Athlete")->findAll();//pour le affcihage de tous
        $sondage = new Sondage();// pour la recerche
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RechercheSondage::class, $sondage);
        $form->handleRequest($request);

        dump($sondage);
        if ($form->isValid()) {
            //i il ya une recherche
            $sondage = $em->getRepository("EshopUserBundle:Sondage")->findBy(array('sujet' => $sondage->getSujet()));//2eme ex
            dump($sondage);
            return $this->render("EshopUserBundle:Sondage:afficherBackOffice.html.twig", array('form' => $form->createView(), 'sondageRecherche' => $sondage,'sondages' => $sondages));
        } else {
            dump($sondage);
            return $this->render("EshopUserBundle:Sondage:afficherBackOffice.html.twig",array('form' => $form->createView(), 'sondages' => $sondages, 'sondageRecherche' => $sondage));
        }



    }
    public function SondageListFronOfficeAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $sondages= $em->getRepository("EshopUserBundle:Sondage")->findAll();//pour le affcihage de tous
        $done =[];
        $isitdone=null;
        foreach ($sondages as $oneofthem) {
        $questionList= $em->getRepository("EshopUserBundle:Question")->findBySondage($oneofthem->getId());
        if($questionList!=null) {
            ;//pour le affcihage de tous
            $isitdone = $em->getRepository("EshopUserBundle:Reponse")->findBy(array('idQuestion' => $questionList[0]->getId(), 'idmembre' => $this->getUser()->getId()));
        }
            $done[$oneofthem->getId()] = $isitdone;

        }

        //$v = $em->getRepository("CompetitionAthleteBundle:Athlete")->findAll();//pour le affcihage de tous
        $sondage = new Sondage();// pour la recerche
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RechercheSondage::class, $sondage);
        $form->handleRequest($request);
        $categories=$em->getRepository("EshopUserBundle:Categorie")->findAll();
        if ($form->isValid()) {
            //i il ya une recherche
            $sondage = $em->getRepository("EshopUserBundle:Sondage")->findBy(array('sujet' => $sondage->getSujet()));//2eme ex
            dump($sondage);
            return $this->render("EshopUserBundle:Sondage:afficherFrontOffice.html.twig", array('form' => $form->createView(), 'sondageRecherche' => $sondage,'sondages' => $sondages ,'done'=>$done,"categories"=>$categories));
        } else {
            dump($sondage);
            return $this->render("EshopUserBundle:Sondage:afficherFrontOffice.html.twig",array('form' => $form->createView(), 'sondages' => $sondages, 'sondageRecherche' => $sondage,'done'=>$done,"categories"=>$categories));
        }



    }
    public function supprimerSondageAction($id){
        $em1 = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getManager();
        $em3 = $this->getDoctrine()->getManager();

        $sondage= $em1->getRepository("EshopUserBundle:Sondage")->find($id);//pour le affcihage de tous
        $questionList= $em2->getRepository("EshopUserBundle:Question")->findBySondage($id);//pour le affcihage de tous

        foreach($questionList as $question)
        {
            $reponses= $em3->getRepository("EshopUserBundle:Reponse")->findByIdQuestion($question);//pour le affcihage de tous
            //    dump($reponses);
            foreach($reponses as $reponse)
            {
                // dump($reponses);
                // dump($reponse);
                $em3->remove($reponse);
                $em3->flush();
            }
            //   dump($question);
            $em2->remove($question);
            $em2->flush();
        }
        $em1->remove($sondage);
        $em1->flush();
        return $this->redirectToRoute('List_sondages_Afficher_back_Office');

    }
    public function chartAction($id)
    {
        // Chart
        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Sattistique : nombre de question par sondage');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
        $data1 = array();

        $em1 = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getManager();
        $em3 = $this->getDoctrine()->getManager();

        $Sondage= $em2->getRepository("EshopUserBundle:Sondage")->find($id);//pour le affcihage de tous

        $questionList= $em2->getRepository("EshopUserBundle:Question")->findBySondage($id);//pour le affcihage de tous
        //dump($questionList);

        foreach($questionList as $question)
        {
            $reponses= $em3->getRepository("EshopUserBundle:Reponse")->findByIdQuestion($question);//pour le affcihage de tous
           // dump($reponses);
            $nbrReponse = $this->getDoctrine()->getRepository("EshopUserBundle:Reponse")->countReponseByQuestion($question);
           // dump((int)$nbrReponse[1]);
            // dump($nbrReponse);


          //      dump($question->getSujet());
                $minidata =array();
                array_push($minidata,$question->getSujet(), (int)$nbrReponse[1]);
                array_push($data1,$minidata);


        }




      /*  dump($minidata);
        dump($data);*/
        dump($data1);


        $ob->series(array(array('type' => 'pie','name' => 'nombre de reponse à cette question', 'data' => $data1)));
        return $this->render('EshopUserBundle:Sondage:chart.html.twig', array(
            'chart' => $ob,'Sondage' =>$Sondage
        ));
    }
}
