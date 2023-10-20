<?php

namespace App\Form;

use App\Entity\Advertisement;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminAdType extends AbstractType
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
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
            ->add('userId', EntityType::class,[
                'class'=>User::class,
                'choices'=>$this->userRepository->getRhUser(),
                'choice_label'=>'email',
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
