<?php

namespace Eshop\UserBundle\form;
use Eshop\UserBundle\Entity\User;
use Eshop\UserBundle\Entity\Echange;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ajoutech extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add("description",TextareaType::class,array('label'=>' ',
            'attr'=>array('placeholder' => 'La description de votre produit', "class"=>"form-control")))


            ->add("prix",NumberType::class,array('label'=>' ','attr'=>array( 'placeholder' => 'Le prix en dt de votre produit',"class"=>"form-control")))

            ->add("prixMinimal",NumberType::class,array('label'=>' ','attr'=>array( 'placeholder' => 'Le prix minimal en dt de votre produit',"class"=>"form-control")))



            ->add('id_cat',EntityType::class,array('label'=>'Type  ',
                'class'=>'Eshop\UserBundle\Entity\Categorie',
                'choice_label'=>'nomCat'))

            ->add('photo', VichImageType::class, [
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
                "attr"=>array("style"=>"margin-bottom:10px","class"=>"form-control" ),"label"=>false
            ])


            ->add('Ajouter',SubmitType::class,array(
                'attr'=>array( "class"=>"button")));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Echange::class,
        ));
    }


    public function getBlockPrefix()
    {
        return 'eshop_user_bundleajoutech';
    }
}