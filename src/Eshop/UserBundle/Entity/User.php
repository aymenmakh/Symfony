<?php

namespace Eshop\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**

 * @ORM\Entity

 * @ORM\Table(name="utilisateur")
 * @ORM\HasLifecycleCallbacks

 */

class User extends BaseUser

{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;

    /**
     *  @ORM\Column(name="nom" , type="string", length=100)
     */
    private $nom;
    /**
     *  @ORM\Column(name="prenom" , type="string", length=100 )
     */
    private $prenom;


    /**
     *  @ORM\Column(name="facebookID" , type="string", length=100, nullable=false)
     */
    protected $facebookID=0;

    private $facebookAccessToken;
    /**
     *  @ORM\Column(name="adresse" , type="string", length=100)
     */
    private $adresse;

    /**
     *  @ORM\Column(name="telephone" , type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string")
     *

     * @Assert\File(mimeTypes={ "image/jpeg" })
     *
     */
    private $path;
    /**
     * @return mixed
     */









    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }



    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getFacebookID()
    {
        return $this->facebookID;
    }

    /**
     * @param mixed $facebookID
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;
    }

    /**
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;
    }


}