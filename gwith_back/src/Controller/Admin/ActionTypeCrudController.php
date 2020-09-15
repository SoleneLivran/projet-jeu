<?php

namespace App\Controller\Admin;

use App\Entity\ActionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActionTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ActionType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
            'name',
            
        ];
    }
}
