<?php

namespace Eshop\UserBundle\Entity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Deal
 *
 * @ORM\Table(name="deal", indexes={@ORM\Index(name="id_entreprise", columns={"id_entreprise"})})
 * @ORM\Entity
 */
/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Deal
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
     * @var integer
     *
     * @ORM\Column(name="nb_ach", type="integer", nullable=false)
     */
    private $nbach=0;


    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=20, nullable=false)
     */
    private $titre;

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
     * @ORM\Column(name="date_emition", type="date", nullable=false)
     */
    private $dateemition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="date", nullable=false)
     */
    private $dateExpiration;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="User")

     *   @ORM\JoinColumn(name="id_entreprise", referencedColumnName="id")

     */
    private $idEntreprise;

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
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return File
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param File $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }



    /**
     * @return \DateTime
     */
    public function getDateemition()
    {
        return $this->dateemition;
    }

    /**
     * @param \DateTime $dateemition
     */
    public function setDateemition($dateemition)
    {
        $this->dateemition = $dateemition;
    }




    /**
     * @return \DateTime
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * @param \DateTime $dateExpiration
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;
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
     * @return \Entreprise
     */
    public function getIdEntreprise()
    {
        return $this->idEntreprise;
    }

    /**
     * @param \Entreprise $idEntreprise
     */
    public function setIdEntreprise($idEntreprise)
    {
        $this->idEntreprise = $idEntreprise;
    }

    /**
     * @return int
     */
    public function getNbach()
    {
        return $this->nbach;
    }

    /**
     * @param int $nbach
     */
    public function setNbach($nbach)
    {
        $this->nbach = $nbach;
    }


}

