<?php

namespace App\Controller\Admin;

use App\Entity\AppUser;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class AppUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AppUser::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            'name',
            'mail',
            'role',
            'stories_played',
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
            AssociationField::new('avatar'),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDateTimeFormat('long', 'short');
        ;
    }
}
