<?php

namespace App\Controller;

use App\Repository\StoryCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/public/story_categories")
 */
class StoryCategoryController extends AbstractController
{
    /**
     * @Route("/", name="story_categories_list", methods={"GET"})
     */
    public function list(StoryCategoryRepository $repository)
    {
        $storyCategory = $repository->findAllOrderByName();
        
        return $this->json(
            $storyCategory,
            200,
            [],
            ["groups" => ["story_categories:list"]]
        );
    }
}
