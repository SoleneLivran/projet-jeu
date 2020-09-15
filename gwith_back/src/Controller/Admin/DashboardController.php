<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use App\Entity\Action;
use App\Entity\ActionType;
use App\Entity\AppUser;
use App\Entity\Avatar;
use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Place;
use App\Entity\PlaceType;
use App\Entity\Rating;
use App\Entity\Scene;
use App\Entity\Story;
use App\Entity\StoryCategory;
use App\Entity\Transition;



class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     * 
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(AppUserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('The GWITH Back-end Interface, welcomes you');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
            MenuItem::section('Create'),
            MenuItem::linkToCrud('Places', 'fa fa-tags', Place::class),
            MenuItem::linkToCrud('Events', 'fa fa-file-text', Event::class),
            MenuItem::linkToCrud('Actions', 'fa fa-file-text', Action::class),

            MenuItem::section('Users'),
            MenuItem::linkToCrud('AppUsers', 'fa fa-comment', AppUser::class),
            MenuItem::linkToCrud('Avatars', 'fa fa-comment', Avatar::class),

            MenuItem::section('Stories'),
            MenuItem::linkToCrud('Stories', 'fa fa-comment', Story::class),
            MenuItem::linkToCrud('Scenes', 'fa fa-comment', Scene::class),
            MenuItem::linkToCrud('Transitions', 'fa fa-comment', Transition::class),
            MenuItem::linkToCrud('Ratings', 'fa fa-comment', Rating::class),
            

            MenuItem::section('Filtres'),
            MenuItem::linkToCrud('Story Categories', 'fa fa-comment', StoryCategory::class),
            MenuItem::linkToCrud('Action Types', 'fa fa-comment', ActionType::class),
            MenuItem::linkToCrud('Event Types', 'fa fa-comment', EventType::class),
            MenuItem::linkToCrud('Place Types', 'fa fa-comment', Placetype::class),

            
        ];
    }
}
