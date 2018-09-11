<?php

namespace EspritBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class image extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
// ...
            ->add('path', FileType::class, array('label' => 'Brochure (PDF file)','data_class' => null))
            ->add('Ajout',SubmitType::class)
// ...
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'esprit_bundleimage';
    }
}
