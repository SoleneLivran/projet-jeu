<?php

namespace App\Controller\Admin;

use App\Entity\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ActionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Action::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $action = new Action();
        $action->getId();
        


        return $action;
    }
    

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            'name',
            'description',
            'sound_file',
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
            AssociationField::new('actionType'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDateTimeFormat('long', 'short');
    }
}
