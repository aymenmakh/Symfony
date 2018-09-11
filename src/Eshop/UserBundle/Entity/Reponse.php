<?php
/**
 * Created by PhpStorm.
 * User: besbes
 * Date: 01/04/2017
 * Time: 18:54
 */

namespace Eshop\UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * * @ORM\Entity(repositoryClass="Eshop\UserBundle\Repository\SondageRepository")
 * @ORM\Table(name="reponse")
 */
class Reponse
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var \Membre
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idmembre", referencedColumnName="id")
     * })
     */
    private $idmembre;
    /**
     * @ORM\Column(type="date")
     */
    private $date;
    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idquestion", referencedColumnName="id")
     * })
     */
    private $idQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=256, nullable=false)
     */
    private $reponse;
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
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \Question
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * @param \Question $idQuestion
     */
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion = $idQuestion;
    }

    /**
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * @param string $reponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    }
}