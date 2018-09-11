<?php

namespace Eshop\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sondage
 *
 * @ORM\Table(name="sondage", indexes={@ORM\Index(name="id_admin", columns={"id_admin"})})
 * @ORM\Entity
 */
class Sondage
{

    public function __construct()
    {

        $this->Questions = new ArrayCollection();
    }

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
     * @ORM\Column(name="sujet", type="string", length=256, nullable=false)
     */
    private $sujet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_émition", type="date", nullable=false)
     */
    private $dateemition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="date", nullable=false)
     */
    private $dateExpiration;

    /**
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_admin", referencedColumnName="id")
     * })
     */
    private $idAdmin;

    /**
     * Question
     * @ORM\OneToMany(targetEntity="Question", mappedBy="sondage",cascade={"persist"})
     * @var object ArrayCollection
     **/
    private $Questions;

    /**
     * @return int
     */
    /**
     * @var \integer
     *
     * @ORM\Column(name="rcounter", type="integer",options={"default" : 0})
     */
    private $rcounter;
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
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * @param string $sujet
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
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
     * @return \Admin
     */
    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

    /**
     * @param \Admin $idAdmin
     */
    public function setIdAdmin($idAdmin)
    {
        $this->idAdmin = $idAdmin;
    }

    /**
     * @return Questions
     */
    public function getQuestions()
    {
        return $this->Questions;
    }

    /**
     * @param Questions $Questions
     */
    public function setQuestions($Questions)
    {
        $this->Questions = $Questions;
    }
    public function addQuestion(Question $question)
    {
        $question->setSondage($this);
        $this->Questions[] = $question;

        return $this;
    }

    /**
     * @return int
     */
    public function getRcounter()
    {
        return $this->rcounter;
    }

    /**
     * @param int $rcounter
     */
    public function setRcounter($rcounter)
    {
        $this->rcounter = $rcounter;
    }

}

