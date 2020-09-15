<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // StoryType = sert a definir comment sont configurees les donnees

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
                "class" => StoryCategory::class
            ]
        );

        $builder->add(
            'status',
            IntegerType::class
        );

        $builder->add(
            'difficulty',
            IntegerType::class
        );

        $builder->add(
            'synopsis',
            TextType::class,
            [
                "required" => false
            ]
        );

        $builder->add(
            'rawScenes',
            TextType::class,
            [
                "mapped" => false,
                // mapped va permettre, dans le story type, de dire quelles datas on ne met pas tout de suite dans la story (les traiter d'abord) = les "raw scenes" envoyees par le front
                // https://symfony.com/doc/current/reference/forms/types/form.html#mapped
                "required" => false
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Story::class,
            // https://symfony.com/doc/3.4/form/csrf_protection.html
            // par default les forms ont une protection CSRF qu'il faut desactiver (champs hidden qui va tout casser si on est pas full Symfony):
            // on a deja la protection des tokens
            'csrf_protection' => false
        ]);
    }
}