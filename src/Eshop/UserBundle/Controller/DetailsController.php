<?php

namespace Eshop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Payum\Bundle\PayumBundle\Controller\PayumController;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Model\DetailsAggregateInterface;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Request\Sync;
use Symfony\Component\HttpFoundation\Request;

class DetailsController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

public function viewAction(Request $request)
{
    // THIS AN EXAMPLE ACTION. YOU HAVE TO OVERWRITE THIS WITH YOUR OWN ACTION.
    // CHECK THE PAYMENT STATUS AND ACT ACCORDING TO IT.

    $token = $this->getPayum()->getHttpRequestVerifier()->verify($request);

    $gateway = $this->getPayum()->getGateway($token->getGatewayName());

    try {
        $gateway->execute(new Sync($token));
    } catch (RequestNotSupportedException $e) {}

    $gateway->execute($status = new GetHumanStatus($token));

    $refundToken = null;
    $captureToken = null;
    $cancelToken = null;

    if ($status->isCaptured()) {
        $refundToken = $this->getPayum()->getTokenFactory()->createRefundToken(
            $token->getGatewayName(),
            $status->getFirstModel(),
            $request->getUri()
        );
    }
    if ($status->isAuthorized()) {
        $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken(
            $token->getGatewayName(),
            $status->getFirstModel(),
            $request->getUri()
        );

        $cancelToken = $this->getPayum()->getTokenFactory()->createCancelToken(
            $token->getGatewayName(),
            $status->getFirstModel(),
            $request->getUri()
        );
    }


    $details = $status->getFirstModel();
    if ($details instanceof  DetailsAggregateInterface) {
        $details = $details->getDetails();
    }

    if ($details instanceof  \Traversable) {
        $details = iterator_to_array($details);
    }

    return $this->render('@EshopUser/Default/view.html.twig', array(
        'status' => $status->getValue(),
        'payment' => htmlspecialchars(json_encode($details, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)),
        'gatewayTitle' => ucwords(str_replace(array('_', '-'), ' ', $token->getGatewayName())),
        'refundToken' => $refundToken,
        'captureToken' => $captureToken,
        'cancelToken' => $cancelToken,
    ));
}
    protected function getPayum()
    {
        return $this->get('payum');
    }
}
