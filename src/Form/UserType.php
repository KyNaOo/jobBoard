<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label'=>false,
                'constraints'=>[
                    new Email([
                        'message'=>'Email non valide'
                    ])
                ]
            ])
            ->add('password', PasswordType::class,[
                'label'=>false
            ])
            ->add('firstName', TextType::class,[
                'label'=>false
            ])
            ->add('lastName', TextType::class,[
                'label'=>false
            ])
            ->add('birth', DateType::class, [
                'label'=>false,
                'years'=>range(date('Y')-100, date('Y')-14),
                ])
            ->add('gender', ChoiceType::class, [
                'label'=>false,
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
                'label'=>false,
                'constraints'=>[
                    new Length([
                        'min'=>10,
                        'max'=>13,
                        'minMessage' => 'The phone number must have at least {{ limit }} digits.',
                        'maxMessage' => 'The phone number cannot have more than {{ limit }} characters.',
                    ]),
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'The phone number can only contain digits (0-9).',
                    ]),
                ]
            ])
            ->add('city', TextType::class,[
                'label'=>false
            ])
            ->add('companyId',null,[
                'label'=>false
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
