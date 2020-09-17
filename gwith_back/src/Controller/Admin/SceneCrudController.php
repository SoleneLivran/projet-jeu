<?php

namespace App\Controller\Admin;

use App\Entity\Scene;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class SceneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Scene::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $scene = new Scene();
        

        return $scene;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
            AssociationField::new('place'),
            AssociationField::new('event'),
            AssociationField::new('story'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDateTimeFormat('long', 'short');
        ;
    }
}
