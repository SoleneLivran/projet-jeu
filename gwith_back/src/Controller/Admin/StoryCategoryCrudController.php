<?php

namespace App\Controller\Admin;

use App\Entity\StoryCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class StoryCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StoryCategory::class;
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
