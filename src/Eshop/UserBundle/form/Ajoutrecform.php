<?php

namespace Eshop\UserBundle\form;
use Eshop\UserBundle\Entity\User;
use Eshop\UserBundle\Entity\Reclamation;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Ajoutrecform extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->

            add("objet",TextareaType::class,array('label'=>' ',
                'attr'=>array('placeholder' => 'description de la reclamation', "class"=>"form-control")))


            ->add("motif",TextareaType::class,array('label'=>' ',
                   'attr'=>array('placeholder' => 'Motif de la reclamation', "class"=>"form-control")))





                   ->add('etat',HiddenType::class,array('data' => 'non traité'))
            ->add('Ajouter',SubmitType::class,array(
                'attr'=>array( "class"=>"button")));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'eshop_user_bundle_ajoutrec';
    }
}
