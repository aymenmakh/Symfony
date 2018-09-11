<?php
/**
 * Created by PhpStorm.
 * User: Khalil
 * Date: 07/04/2017
 * Time: 17:07
 */

namespace Eshop\UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PaymentToken extends Token
{

}