<?php

namespace App\Controller\Admin;

use App\Entity\ActionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ActionTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ActionType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            'name',
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
        ];
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDateTimeFormat('long', 'short');
        ;
    }

}
