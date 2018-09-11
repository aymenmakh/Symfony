<?php

// src/AppBundle/Form/ProductType.php

namespace Eshop\UserBundle\form;



use Eshop\UserBundle\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Tests\Command\CacheClearCommand\Fixture\TestAppKernel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use FOS\UserBundle\Util\LegacyFormHelper;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
// ...->add('titre', TextType::class, array("attr" => array("style" => "margin-top:8px", "class" =>
        //    " form-control")))"attr" => array("style" => "margin-top:8px"
             ->add('nom',TextType::class,array("attr" => array("class" => "form-control")))
             ->add('description',TextareaType::class,array("attr" => array("class" => "form-control")))



          //  ->add('idCategorie', EntityType::class, array('label' =>'Categorie ',"attr"=>array("class" => "form-control"),
//
                //   'choices' =>array('vetement' =>'4',

                     //   'voiture' =>'5','telephone' =>'6','meuble' =>'7')


              // ))
            ->add('etat', ChoiceType::class, array('label' =>'Type ',"attr"=>array("class" => "form-control"),

                    'choices' =>array('Neuf' =>'Neuf',

                        'Utilisé' =>'Occasion'))
            )

            ->add('idCategorie',EntityType::class,array('label'=>'Type  ',
                'class'=>'Eshop\UserBundle\Entity\Categorie',
                'choice_label'=>'nomcat'))




            ->add('photo', FileType::class, array('label' => 'photo (PNG file)' ,'data_class' => null,'required' => false))
            ->add('prix',TextType::class,array("attr" => array("class" => "form-control")) )

            ->add('Ajout',SubmitType::class,array("attr"=> array("class" => "button")))
// ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Produit::class,
        ));
    }
}