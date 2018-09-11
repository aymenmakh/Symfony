<?php
/**
 * Created by PhpStorm.
 * User: thelo
 * Date: 26/03/2017
 * Time: 15:47
 */

namespace Eshop\UserBundle\form;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Eshop\UserBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class UpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $date = new \DateTime('+1 day');
        $date = $date->format('Y-m-d');
        $date2 = new \DateTime('');
        $date2 = $date2->format('H:m:s');
        $builder
            ->add('sujet', TextareaType::class,[ 'attr'=>['class'=>'form-control text-center','placeholder'=>'Sujet'],'required'=>true,'label'=>false])
            ->add('dateemition', DateTimeType::class ,['widget' => 'single_text','attr'=>['class'=>'form-control'],  'required'=>true,'label'=>false])
            ->add('dateExpiration', DateTimeType::class ,['widget' => 'single_text',  'attr'=>['class'=>'form-control'],'required'=>true,'label'=>false])
            ->add('Questions',CollectionType::class, array(  'entry_options' => array('label' => 'Question'),'entry_type'   => AddQuestionType::class,
                'allow_add' => true,
                //   'by_reference'=>false

            ))
            ->add('Modifer',SubmitType::class,[ 'attr'=>['class'=>'btn btn-default']]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'member_bundle_update_type';
    }
}
