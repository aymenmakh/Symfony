<?php

namespace Eshop\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity
 */
class Admin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_admin", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=256, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=256, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="E_mail", type="string", length=256, nullable=false)
     */
    private $eMail;

    /**
     * @var string
     *
     * @ORM\Column(name="Mdp", type="string", length=256, nullable=false)
     */
    private $mdp;


}

