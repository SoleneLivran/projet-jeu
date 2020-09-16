<?php

namespace App\Controller\Admin;

use App\Entity\EventType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class EventTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventType::class;
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
