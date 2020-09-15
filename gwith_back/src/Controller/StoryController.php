<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Story;
use App\Repository\StoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/stories")
 */
class StoryController extends AbstractController
{
    /**
     * @Route("/", name="stories_list", methods={"GET"})
     */
    public function list(StoryRepository $repository, Request $request)
    {
        if ($request->query->has('story_category')) {
            $storyCategory = $request->query->get('story_category');
            $stories = $repository->findAllByCategory($storyCategory);
        } else {
            $stories = $repository->findAllOrderByTitle();
        }
        return $this->json(
            $stories,
            200,
            [],
            ["groups" => ["stories:list"]]
        );
    }

    /**
     * @Route("/latest_ten", name="stories_latest_ten", methods={"GET"})
     */
    public function listLatestTen(StoryRepository $repository)
    {
        $stories = $repository->findLatestTen();
        return $this->json(
            $stories,
            200,
            [],
            ["groups" => ["stories:list"]]
        );
    }

    /**
     * @Route("/top_ten", name="stories_top_ten", methods={"GET"})
     */
    public function listTopTen(StoryRepository $repository)
    {
        $stories = $repository->findTopTen();
        return $this->json(
            $stories,
            200,
            [],
            ["groups" => ["stories:list"]]
        );
    }

    /**
     * @Route("/{id}", name="story_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view(Story $story)
    {
        return $this->json(
            $story,
            200,
            [],
            ["groups" => ["story:view"]]
        );
    }

    /**
     * @Route("/", name="story_create", methods={"POST"})
     */
    public function create(Story $story)
    {
        // traitement des donnees de la request par le "processing form" de Symfo
        // https://symfony.com/doc/current/forms.html#processing-forms

        // on cree un objet Story
        $story = new Story();

        // mapped va permettre, dans le story type, de dire quelles datas on ne met pas tout de suite dans la story (les traiter d'abord) = les "raw scenes" envoyees par le front
        // https://symfony.com/doc/current/reference/forms/types/form.html#mapped

        $form = $this->createForm(StoryType::class, $story);
    }
}



