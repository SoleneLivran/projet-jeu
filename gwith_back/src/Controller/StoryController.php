<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Story;
use App\Repository\StoryRepository;

/**
 * @Route("/api/stories")
 */
class StoryController extends AbstractController
{
    /**
     * @Route("/", name="stories_list")
     */
    public function list(StoryRepository $repository)
    {
        $stories = $repository->findAllOrderByTitle();
        return $this->json(
            $stories,
            200,
            [],
            ["groups" => ["stories:list"]]
        );
    }

    /**
     * @Route("/latest_ten", name="stories_latest_ten")
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
     * @Route("/top_ten", name="stories_top_ten")
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
     * @Route("/{id}", name="story_view", requirements={"id"="\d+"})
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
}



