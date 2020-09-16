<?php

namespace App\Controller\Admin;

use App\Entity\Avatar;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class AvatarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Avatar::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
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
