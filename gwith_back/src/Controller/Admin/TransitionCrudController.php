<?php

namespace App\Controller\Admin;

use App\Entity\Transition;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class TransitionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transition::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
            AssociationField::new('currentScene'),
            AssociationField::new('action'),
            AssociationField::new('nextScene'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDateTimeFormat('long', 'short');
        ;
    }
}
