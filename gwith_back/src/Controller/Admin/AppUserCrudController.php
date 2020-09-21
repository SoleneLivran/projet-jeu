<?php

namespace App\Controller\Admin;

use App\Entity\AppUser;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class AppUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AppUser::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            EmailField::new('mail'),
            ArrayField::new('roles'),
            IntegerField::new('stories_played'),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
            AssociationField::new('avatar'),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDateTimeFormat('long', 'short')

            // only super_admin can view userList, and CRUD methods
            //->setEntityPermission('ROLE_SUPER_ADMIN')
        ;
    }

}


