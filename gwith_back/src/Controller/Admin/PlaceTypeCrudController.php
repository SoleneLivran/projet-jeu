<?php

namespace App\Controller\Admin;

use App\Entity\PlaceType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class PlaceTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlaceType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            'name',
            'picture_file',
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
