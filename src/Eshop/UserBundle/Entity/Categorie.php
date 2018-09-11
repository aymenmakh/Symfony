<?php

namespace Eshop\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcat;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCat", type="string", length=256, nullable=false)
     */
    private $nomcat;

    /**
     * @return int
     */
    public function getIdcat()
    {
        return $this->idcat;
    }

    /**
     * @param int $idcat
     */
    public function setIdcat($idcat)
    {
        $this->idcat = $idcat;
    }

    /**
     * @return string
     */
    public function getNomcat()
    {
        return $this->nomcat;
    }

    /**
     * @param string $nomcat
     */
    public function setNomcat($nomcat)
    {
        $this->nomcat = $nomcat;
    }



}

