<?php

namespace Eshop\UserBundle\form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Tests\File\FileTest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class pubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateD', DateType::class, array(

            'widget' => 'single_text',
        ))
            ->add('dateF', DateType::class, array(

                'widget' => 'single_text',
            ))

            ->add('photo', FileType::class, array('label' => 'Brochure (PDF file)','data_class' => null))

            ->add('emp',  HiddenType::class, array(
                'data' => '20'))

            ->add('Ajout',SubmitType::class,array("attr" => array("class" => "form-control")));
    }

    public function configureOptions(OptionsResolver $resolver)
    {


    }

    public function getBlockPrefix()
    {
        return 'esprit_bundlepub_type';
    }
}
