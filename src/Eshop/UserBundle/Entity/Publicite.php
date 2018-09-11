<?php

namespace Eshop\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publicite
 *
 * @ORM\Table(name="publicite", indexes={@ORM\Index(name="id_entreprise", columns={"id_entreprise"})})
 * @ORM\Entity
 * * @ORM\Entity(repositoryClass="Eshop\UserBundle\Repository\ProduitRepository")
 */
class Publicite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=256, nullable=false)
     */
    private $photo;


    /**
     * @var date
     *
     * @ORM\Column(name="date_debut", type="date", length=256)
     */
    private $dated;
    /**
     * @var date
     *
     * @ORM\Column(name="date_fin", type="date", length=256)
     */
    private $datef;

    /**
     * @var integer
     *
     * @ORM\Column(name="emp", type="integer", length=256)
     */
    private $emp;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", length=256)
     */
    private $prix;




    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="user")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_membre", referencedColumnName="id")
     * })
     */
    private $idMembre;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }


    public function getDated()
    {
        return $this->dated;
    }

    /**
     * @param date $dated
     */
    public function setDated($dated)
    {
        $this->dated = $dated;
    }

    /**
     * @return date
     */
    public function getDatef()
    {
        return $this->datef;
    }

    /**
     * @param date $datef
     */
    public function setDatef($datef)
    {
        $this->datef = $datef;
    }

    /**
     * @return int
     */
    public function getEmp()
    {
        return $this->emp;
    }

    /**
     * @param int $emp
     */
    public function setEmp($emp)
    {
        $this->emp = $emp;
    }

    /**
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return \User
     */
    public function getIdMembre()
    {
        return $this->idMembre;
    }

    /**
     * @param \User $idMembre
     */
    public function setIdMembre($idMembre)
    {
        $this->idMembre = $idMembre;
    }


}

