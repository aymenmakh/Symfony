<?php
/**
 * Created by PhpStorm.
 * User: thelo
 * Date: 26/03/2017
 * Time: 15:47
 */

namespace Eshop\UserBundle\form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class AddQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('sujet',TextType::class,[ 'attr'=>['class'=>'form-control text-center','placeholder'=>'Titre'],'required'=>true,'label'=>false])
   ->add('reponse1',TextType::class,[ 'attr'=>['class'=>'form-control text-center','placeholder'=>'Réponse 1'],'required'=>true,'label'=>false])
            ->add('reponse2',TextType::class,[ 'attr'=>['class'=>'form-control text-center','placeholder'=>'Réponse 2'],'required'=>true,'label'=>false])
            ->add('reponse3',TextType::class,[ 'attr'=>['class'=>'form-control text-center','placeholder'=>'Réponse 3'],'required'=>false,'label'=>false])
            ->add('reponse4',TextType::class,[ 'attr'=>['class'=>'form-control text-center','placeholder'=>'Réponse 4'],'required'=>false,'label'=>false])
            ->add('reponse5',TextType::class,[ 'attr'=>['class'=>'form-control text-center','placeholder'=>'Réponse 5'],'required'=>false,'label'=>false])
;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eshop\UserBundle\Entity\Question',
        ));
    }

    public function getName()
    {
        return 'member_bundle_add_event_type';
    }
}
