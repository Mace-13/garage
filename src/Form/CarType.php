<?php

namespace App\Form;

use App\Entity\Car;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class CarType extends AbstractType
{
    private function getConfiguration($label,$placeholder, $options=[]){
        return array_merge([
            'label'=>$label,
            'attr'=> [
                'placeholder'=>$placeholder
            ]

        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque', TextType::class, $this->getConfiguration('Marque','La marque'))
            ->add('modele', TextType::class, $this->getConfiguration('Modele','Le modele'))
            ->add('slug', TextType::class, $this->getConfiguration('Slug','Adresse web (automatique)',[
                'required' => false
            ]))
            ->add('km',IntegerType::class, $this->getConfiguration('Km','km'))
            ->add('prix', IntegerType::class, $this->getConfiguration('Prix','le prix'))
            ->add('owner', IntegerType::class, $this->getConfiguration('Owner','nombre'))
            ->add('cylindre', IntegerType::class, $this->getConfiguration('Cylindre','cylindre'))
            ->add('puissance', IntegerType::class, $this->getConfiguration('Puissance','puissance'))
            ->add('carburant',TextType::class, $this->getConfiguration('Carburant','Le carburant') )
            ->add('miseCirculation', DateType::class, $this->getConfiguration('Date', ''))
            ->add('transmission',TextType::class, $this->getConfiguration('Transmission','transmission') )
            ->add('description', TextareaType::class, $this->getConfiguration('Description','Description'))
            ->add('carOption', TextareaType::class, $this->getConfiguration('Options','options') )
            ->add('coverImage',UrlType::class, $this->getConfiguration('URL de l\'image','Donnez l\'adresse de votre image'))
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true, // permet d'ajouter de nouveaux éléments et ajouter un data_prototype
                    'allow_delete' => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
