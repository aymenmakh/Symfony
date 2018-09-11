<?php

namespace Eshop\UserBundle\Controller;
use Eshop\UserBundle\Entity\PaymentDetails;

use Payum\Core\Request\GetHumanStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Payum\Core\Bridge\Symfony\Form\Type\CreditCardType;
use Payum\Core\Model\CreditCardInterface;
use Payum\Core\Payum;
use Payum\Core\Security\SensitiveValue;
use Payum\Stripe\Request\Api\CreatePlan;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Range;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Request;
class PaymentController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function prepareStripeJsPaymentAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('EshopUserBundle:Commandes')->find($id);
        $gatewayName = 'stripe';
        if ($commande->getReference() == 0){
        $storage = $this->getPayum()->getStorage('Eshop\UserBundle\Entity\PaymentDetails');

        /** @var PaymentDetails $details */
        $details = $storage->create();
        $details["amount"] = $commande->getCommande()['prixTTC']*100;
        $details["currency"] = 'USD';
        $details["description"] = 'a description';
        $storage->update($details);
$commande->setReference(1);
$em->persist($commande);
$em->flush();
        $captureToken = $this->get('payum')->getTokenFactory()->createCaptureToken(
            $gatewayName,
            $details,
            'acme_payment_done' // the route to redirect after capture;
        );

        return $this->redirect($captureToken->getTargetUrl()); }
        else{return $this ->redirectToRoute('factures');
    }
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function createPurchaseForm()
    {
        return $this->createFormBuilder()
            ->add('amount', null, array(
                'data' => 1,
                'constraints' => array(new Range(array('max' => 2)))
            ))
            ->add('currency', null, array('data' => 'USD'))
            ->getForm()
            ;
    }

    /**
     * @return Payum
     */
    protected function getPayum()
    {
        return $this->get('payum');
    }
    public function captureDoneAction(Request $request)
    {
        $token = $this->get('payum')->getHttpRequestVerifier()->verify($request);

        $identity = $token->getDetails();
        $model = $this->get('payum')->getStorage($identity->getClass())->find($identity);

        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        // you can invalidate the token. The url could not be requested any more.
        // $this->get('payum')->getHttpRequestVerifier()->invalidate($token);

        // Once you have token you can get the model from the storage directly.
        //$identity = $token->getDetails();
        //$details = $payum->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $details = $status->getFirstModel();

        // you have order and payment status
        // so you can do whatever you want for example you can just print status and payment details.

        return new JsonResponse(array(
            'status' => $status->getValue(),
            'details' => iterator_to_array($details),
        ));
    }
}