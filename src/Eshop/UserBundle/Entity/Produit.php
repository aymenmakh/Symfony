<?php

namespace Eshop\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="id_membre", columns={"id_membre"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Eshop\UserBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @ORM\Column(name="nom", type="string", length=256, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=256, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=256, nullable=true)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=256, nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=256, nullable=false)
     */
    private $photo;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=true)
     */
    private $prix;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_membre", referencedColumnName="id")
     * })
     */
    private $idmembre;
    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var booelan
     *
     * @ORM\Column(name="Enpromotion", type="boolean")
     */
    private $Enpromotion='0' ;


    /**
     * @var integer
     *
     * @ORM\Column(name="promo", type="integer")
     */
    private $promo=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="prixP", type="integer")
     */
    private $prixP=0;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="idCat")
     * })
     */
    private $idCategorie;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
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
     * @return \Membre
     */
    public function getIdmembre()
    {
        return $this->idmembre;
    }

    /**
     * @param \Membre $idmembre
     */
    public function setIdmembre($idmembre)
    {
        $this->idmembre = $idmembre;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return booelan
     */
    public function getEnpromotion()
    {
        return $this->Enpromotion;
    }

    /**
     * @param booelan $Enpromotion
     */
    public function setEnpromotion($Enpromotion)
    {
        $this->Enpromotion = $Enpromotion;
    }

    /**
     * @return int
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * @param int $promo
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;
    }

    /**
     * @return int
     */
    public function getPrixP()
    {
        return $this->prixP;
    }

    /**
     * @param int $prixP
     */
    public function setPrixP($prixP)
    {
        $this->prixP = $prixP;
    }

    /**
     * @return \Categorie
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * @param \Categorie $idCategorie
     */
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }




}

