<?php

namespace Eshop\UserBundle\form;

use Eshop\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use FOS\UserBundle\Util\LegacyFormHelper;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
// ...
            ->add('nom', TextType::class,array('attr'  => array("class" => "form-control")))
            ->add('prenom', TextType::class,array('attr'  => array("class" => "form-control")) )
            ->add('adresse', TextType::class,array('attr'  => array("class" => "form-control")))
            ->add('telephone', TextType::class,array('attr'  => array("class" => "form-control")))

            ->add('path', FileType::class, array('label' => 'Image(PNG)','data_class' => null))
            ->add('Ajout',SubmitType::class,array('attr'  => array("class" => "button")))
// ...
        ;

    }




}
