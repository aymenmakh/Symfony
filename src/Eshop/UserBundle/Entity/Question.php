<?php
/**
 * Created by PhpStorm.
 * User: thelo
 * Date: 26/03/2017
 * Time: 14:57
 */

namespace Eshop\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column( type="string", length=256, nullable=false)
     */
    private $sujet;
    /**
     * @ORM\Column(type="string", length=256, nullable=false)
     */
    private $reponse1;
    /**
     * @ORM\Column(type="string", length=256, nullable=false)
     */
    private $reponse2;
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $reponse3;
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $reponse4;
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $reponse5;
    /**
     *@ORM\ManyToOne(targetEntity="Sondage",inversedBy="questions")
     *@ORM\JoinColumn(name="id_sondage",referencedColumnName="id")
     */
    private $sondage;
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
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * @param mixed $sujet
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    }

    /**
     * @return mixed
     */
    public function getReponse1()
    {
        return $this->reponse1;
    }

    /**
     * @param mixed $reponse1
     */
    public function setReponse1($reponse1)
    {
        $this->reponse1 = $reponse1;
    }

    /**
     * @return mixed
     */
    public function getReponse2()
    {
        return $this->reponse2;
    }

    /**
     * @param mixed $reponse2
     */
    public function setReponse2($reponse2)
    {
        $this->reponse2 = $reponse2;
    }

    /**
     * @return mixed
     */
    public function getReponse3()
    {
        return $this->reponse3;
    }

    /**
     * @param mixed $reponse3
     */
    public function setReponse3($reponse3)
    {
        $this->reponse3 = $reponse3;
    }

    /**
     * @return mixed
     */
    public function getReponse4()
    {
        return $this->reponse4;
    }

    /**
     * @param mixed $reponse4
     */
    public function setReponse4($reponse4)
    {
        $this->reponse4 = $reponse4;
    }

    /**
     * @return mixed
     */
    public function getReponse5()
    {
        return $this->reponse5;
    }

    /**
     * @param mixed $reponse5
     */
    public function setReponse5($reponse5)
    {
        $this->reponse5 = $reponse5;
    }

    /**
     * @return mixed
     */
    public function getSondage()
    {
        return $this->sondage;
    }

    /**
     * @param mixed $sondage
     */
    public function setSondage($sondage)
    {
        $this->sondage = $sondage;
    }

}