<?php

namespace App\Controller\Admin;

use App\Entity\Story;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class StoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Story::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            'title',
            'status',
            'picture_file',
            'rating',
            'difficulty',
            'synopsis',
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
            DateTimeField::new('publishedAt'),
            AssociationField::new('firstScene'),
            AssociationField::new('author'),
            AssociationField::new('category'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDateTimeFormat('long', 'short');
        ;
    }
}
