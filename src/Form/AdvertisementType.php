<?php

namespace App\Form;

use App\Entity\Advertisement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ])
            ->add('description', TextareaType::class,[
                'label'=> false,
            ])
            ->add('location', TextType::class,[
                'label'=> false,
            ])
            ->add('adress', TextType::class,[
                'label'=> false,
            ])
            ->add('wages', TextType::class,[
                'label'=> false,
            ])
            ->add('workingTime', TextType::class,[
                'label'=> false,
            ])
            ->add('contract', TextType::class,[
                'label'=> false,
            ])
      
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertisement::class,
        ]);
    }
}
