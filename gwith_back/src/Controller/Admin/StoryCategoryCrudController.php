<?php

namespace App\Controller\Admin;

use App\Entity\StoryCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
        ];
    }
}
