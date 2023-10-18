<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Choice;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label'=>'Adresse Email'
            ])
            ->add('firstName', TextType::class,[
                'label'=>'Prénom'
            ])
            ->add('lastName', TextType::class,[
                'label'=>'Nom'
            ])
            ->add('birth', DateType::class, [
                'label'=>'Date de naissance',
                'years'=>range(date('Y')-100, date('Y')-14),
                ])
            ->add('gender', ChoiceType::class, [
                'label'=>'Genre',
                'choices' => [
                    'Male' => 1,
                    'Female' => 2,
                    'Other' => 3,
                ],
                'constraints' => [
                    new Choice([1, 2, 3]),
                ],
            ])
            ->add('phone', TextType::class,[
                'label'=>'N° tel'
            ])
            ->add('city', TextType::class,[
                'label'=>'Ville'
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
