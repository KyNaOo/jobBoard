<?php

namespace App\Form;

use App\Entity\Advertisement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertisementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>"Titre"
                ]
            ])
            ->add('description', TextareaType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>"Description"
                ]
            ])
            ->add('location', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>"Ville"
                ]
            ])
            ->add('adress', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>"Adresse"
                ]
            ])
            ->add('wages', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>"Salaire"
                ]
            ])
            ->add('workingTime', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>"Heures par semaine"
                ]
            ])
            ->add('contract', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>"Type de contrat"
                ]
            ])
            ->add('companyId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertisement::class,
        ]);
    }
}
