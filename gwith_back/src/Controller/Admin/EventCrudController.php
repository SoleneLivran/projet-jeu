<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $event = new Event();
        return $event;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            'name',
            'description',
            'sound_file',
            'is_end',
            'picture_file',
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
            AssociationField::new('eventType')
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDateTimeFormat('long', 'short');
            
        ;
    }
}
