<?php

namespace App\Form;

use App\Entity\AppUser;
use App\Entity\Story;
use App\Entity\StoryCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // StoryType = defines how the data is configured/organized

        $builder->add(
            'title',
            TextType::class,
            [
                "required" => false
            ]
        );

        $builder->add(
            'pictureFile',
            TextType::class,
            [
                "required" => false
            ]
        );

        $builder->add(
            'category',
            EntityType::class,
            [
                "class" => StoryCategory::class,
                "required" => false
            ]
        );

        $builder->add(
            'status',
            IntegerType::class
        );

        $builder->add(
            'difficulty',
            IntegerType::class,
            [
                "required" => false
            ]
        );

        $builder->add(
            'synopsis',
            TextType::class,
            [
                "required" => false
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Story::class,
            // https://symfony.com/doc/3.4/form/csrf_protection.html
            // by default forms have a CSRF protection with a hidden field, we have to deactivate it (it's made for symfony but if it's not a "full symfony" project we risk some errors)
            // in our project we have this protection with the tokens
            'csrf_protection' => false,
            "allow_extra_fields" => true
        ]);
    }
}