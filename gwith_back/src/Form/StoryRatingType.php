<?php

namespace App\Form;

use App\Entity\Rating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoryRatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {          
        $builder
            ->add(
                'note',
                IntegerType::class,
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
            'csrf_protection' => false,
            "allow_extra_fields" => true
        ]);
    }
}
