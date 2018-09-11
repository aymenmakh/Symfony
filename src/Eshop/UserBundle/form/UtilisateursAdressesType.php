<?php

namespace Eshop\UserBundle\form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateursAdressesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class,array('attr'  => array('class' => 'input form-control')))->add('prenom',TextType::class,array('attr'  => array('class' => 'input form-control')))->add('telephone',NumberType::class,array('attr'  => array('class' => 'input form-control')))->add('adresse',TextType::class,array('attr'  => array('class' => 'input form-control')))->add('cp',TextType::class,array('attr'  => array('class' => 'input form-control')))->add('pays', CountryType::class,array('attr'  => array('class' => 'input form-control')))->add('ville', TextType::class,array('attr'  => array('class' => 'input form-control')))->add('complement',TextType::class,array('attr'  => array('class' => 'input form-control')))->add('Continuer',SubmitType::class,array('attr'  => array('class' => 'button pull-right')));//->add('utilisateur');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eshop\UserBundle\Entity\UtilisateursAdresses'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eshop_userbundle_utilisateursadresses';
    }


}
