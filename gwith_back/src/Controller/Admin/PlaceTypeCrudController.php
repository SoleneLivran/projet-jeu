<?php

namespace App\Controller\Admin;

use App\Entity\PlaceType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
        ];
    }
}
