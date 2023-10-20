<?php

namespace App\Form;

use App\Entity\Postulate;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;

class AdminPosType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userId', EntityType::class,[
                'class'=>User::class,
                'choices'=>$this->userRepository->getRoleUser(),
                'choice_label'=>'email',
                'required'=>false,
                'label'=>false
            ])
            ->add('advertisementId',null,[
                'label'=>false
            ])

            ->add('emailSent', TextareaType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>"Email de demande"
                ]
            ])
            ->add('userName', TextType::class,[
                'label'=> false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>"Prénom"
                ]
            ])
            ->add('userLastName', TextType::class,[
                'label'=> false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>"Nom de famille"
                ]
            ])
            ->add('userTel', TextType::class,[
                'label'=> false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>"tel"
                ],   
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{10,13}$/',
                        'message' => 'Please enter a valid phone number (10 to 13 digits).',
                    ]),
                ],
            ])
            ->add('userEmail', TextType::class,[
                'label'=> false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>"Email"
                ],
                'constraints' => [
                    new Email([
                        'message' => 'The email "{{ value }}" is not a valid email.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Postulate::class,
        ]);
    }
}
