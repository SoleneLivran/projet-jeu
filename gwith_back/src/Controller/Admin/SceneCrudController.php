<?php

namespace App\Controller\Admin;

use App\Entity\Scene;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

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
            'id',
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
            AssociationField::new('place'),
            AssociationField::new('event'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDateTimeFormat('long', 'short');
        ;
    }
}
