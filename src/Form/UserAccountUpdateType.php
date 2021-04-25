<?php

namespace App\Form;

use App\Entity\AppUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserAccountUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newName', TextType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 4096,
                    ]),
                ],
            ])
        ;

        $builder
            ->add(
                'oldPassword',
                PasswordType::class,
                [
                    'mapped' => false,
                    'constraints' => [
                            new UserPassword()
                    ]
                ]
            );

        $builder
            ->add('newPassword', PasswordType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'max' => 4096,
                    ]),
                ],
            ]);

        $builder
            ->add('newMail',EmailType::class, [
                'mapped' => false,
                'required' => false
            ]);       
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AppUser::class,
            'csrf_protection' => false,
        ]);
    }
}
