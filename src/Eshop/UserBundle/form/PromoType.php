<?php

namespace EspritBundle\Form;


use EspritBundle\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('promo', ChoiceType::class, array('label' =>'Type ',

                'choices' =>array('20%' =>'30',

                    '30%' =>'20'))
        )
        ->add('prixP',TextType::class,array("attr" => array("class" => "form-control")))
        ->add('ajout', SubmitType::class,array("attr" => array("class" => "button")));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Produit::class,
        ));

    }


}
