<?php

namespace App\Form;

use App\Entity\AppUser;
use Symfony\Component\Form\AbstractType;
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
            ->add('oldName', TextType::class)
            ->add('newName', TextType::class)
        ;

        $builder
            ->add(
                'oldPassword',
                PasswordType::class,
                [
                    "mapped" => false,
                    "constraints" => [
                        new UserPassword()
                    ]
                ]
            )
            ->add(
                'newPassword', 
                RepeatedType::class, 
                [
                    "mapped" => false,
                    'type' => PasswordType::class,
                    'constraints' => [
                        new NotBlank(),
                        new Length([
                            'min' => 6,
                            'max' => 4096,
                        ]),
                    ],
                ]
            );

        $builder
            ->add('oldMail',EmailType::class)
            ->add('newMail',EmailType::class);

        $builder
            ->add('avatar', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AppUser::class,
        ]);
    }
}
