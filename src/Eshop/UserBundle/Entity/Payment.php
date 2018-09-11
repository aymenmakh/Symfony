<?php
/**
 * Created by PhpStorm.
 * User: Khalil
 * Date: 07/04/2017
 * Time: 23:15
 */

namespace Eshop\UserBundle\Entity;

use Payum\Core\Model\ArrayObject;
use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Payment as BasePayment;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class Payment extends BasePayment
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;
}