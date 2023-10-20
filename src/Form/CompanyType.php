<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>false,
                'required'=>true
            ])
            ->add('location', TextType::class,[
                'label'=>false,
                'required'=>true
            ])
            ->add('creationDate', DateTYpe::class,[
                'label'=>false,
                'years'=>range(date('Y')-100, date('Y'))
            ])
            ->add('revenues', TextType::class,[
                'label'=>false,
                'required'=>true
            ])
            ->add('nbEmployees',IntegerType::class,[
                'label'=>false,
                'required'=>true
            ] )
            ->add('domain', TextType::class,[
                'label'=>false,
                'required'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
