<?php

namespace App\Controller\Admin;

use App\Entity\Transition;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TransitionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transition::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'id',
          
        ];
    }
}
