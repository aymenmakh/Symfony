<?php

namespace Eshop\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Echange
 *
 * @ORM\Table(name="echange", indexes={@ORM\Index(name="echange_ibfk_1", columns={"e_id"}), @ORM\Index(name="echange_ibfk_2", columns={"id_cat"})})
 * @ORM\Entity(repositoryClass="Eshop\UserBundle\Repository\EchangeRepository")
 */
/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Echange
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
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat="attente";

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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File
     */

    private $photo;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @return mixed
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param mixed $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeb", type="date", nullable=false)
     */
    private $datedeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date", nullable=false)
     */
    private $datefin;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var float
     *
     * @ORM\Column(name="prixMinimal", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixMinimal;


    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="e_id", referencedColumnName="id")
     * })
     */
    private $e_id;





    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cat", referencedColumnName="idCat")
     * })
     */
    private $id_cat;




    /**
     * @return \Categorie
     */
    public function getIdCat()
    {
        return $this->id_cat;
    }

    /**
     * @param \Categorie $id_cat
     */
    public function setIdCat($id_cat)
    {
        $this->id_cat = $id_cat;
    }





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
     * @return \DateTime
     */
    public function getDatedeb()
    {
        return $this->datedeb;
    }

    /**
     * @param \DateTime $datedeb
     */
    public function setDatedeb($datedeb)
    {
        $this->datedeb = $datedeb;
    }

    /**
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param \DateTime $datefin
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return float
     */
    public function getPrixMinimal()
    {
        return $this->prixMinimal;
    }

    /**
     * @param float $prixMinimal
     */

    public function setPrixMinimal($prixMinimal)
    {
        $this->prixMinimal = $prixMinimal;
    }

    /**
     * @return \User
     */
    public function getEId()
    {
        return $this->e_id;
    }

    /**
     * @param \User $e_id
     */
    public function setEId($e_id)
    {
        $this->e_id = $e_id;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }





    public function __construct()
    {
        $this->datedeb = new \DateTime('now');
        $this->datefin = new \DateTime('now');
    }








}

