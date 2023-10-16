<?php
namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\DateType as TypesDateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('email', EmailType::class, [ // Use EmailType for email input
            'constraints' => [
                new Assert\Email([
                    'message' => 'Please enter a valid email address.',
                ]),
            ],
        ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 100,
                    ]),   
                ],
                'label'=>'Password'
            ])
            ->add('firstName')
            ->add('lastName')
            ->add('birth', DateType::class, [
            'years'=>range(date('Y')-100, date('Y')-14),
                
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 1,
                    'Female' => 2,
                    'Other' => 3,
                ],
                'constraints' => [
                    new Choice([1, 2, 3]),
                ],
            ])
            ->add('phone', TextType::class, [ // Change to TextType for phone input
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/', // Define your regex pattern for a valid phone number
                        'message' => 'Please enter a valid phone number (10 digits).',
                    ]),
                ],
            ])
            ->add('city');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
?>