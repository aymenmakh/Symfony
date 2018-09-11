<?php
/**
 * Created by PhpStorm.
 * User: thelo
 * Date: 26/03/2017
 * Time: 17:35
 */

namespace Eshop\UserBundle\Entity;


class Utils
{
    private $nb;

    /**
     * @return mixed
     */
    public function getNb()
    {
        return $this->nb;
    }

    /**
     * @param mixed $nb
     */
    public function setNb($nb)
    {
        $this->nb = $nb;
    }

}