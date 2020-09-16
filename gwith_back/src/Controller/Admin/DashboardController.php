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
            MenuItem::linkToCrud('Places', 'fas fa-globe-americas', Place::class),
            MenuItem::linkToCrud('Events', 'fas fa-fighter-jet', Event::class),
            MenuItem::linkToCrud('Actions', 'fas fa-bicycle', Action::class),

            MenuItem::section('Users'),
            MenuItem::linkToCrud('AppUsers', 'fas fa-user', AppUser::class),
            MenuItem::linkToCrud('Avatars', 'fas fa-image', Avatar::class),

            MenuItem::section('Stories'),
            MenuItem::linkToCrud('Stories', 'fa fa-book-open', Story::class),
            MenuItem::linkToCrud('Scenes', 'fa fa-video', Scene::class),
            MenuItem::linkToCrud('Transitions', 'fa fa-forward', Transition::class),
            MenuItem::linkToCrud('Ratings', 'fa fa-star-half-alt', Rating::class),
            

            MenuItem::section('Filtres'),
            MenuItem::linkToCrud('Story Categories', 'fa fa-book-dead', StoryCategory::class),
            MenuItem::linkToCrud('Action Types', 'fas fa-skiing', ActionType::class),
            MenuItem::linkToCrud('Event Types', 'fas fa-cloud-moon-rain', EventType::class),
            MenuItem::linkToCrud('Place Types', 'fas fa-map-marked-alt', Placetype::class),

            
        ];
    }
}
