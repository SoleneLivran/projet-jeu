<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Story;
use App\Form\StoryType;
use App\Repository\StoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use App\Service\StoryManager;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api")
 */
class StoryController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var StoryManager
     */
    private $storyManager;

    public function __construct(Security $security, StoryManager $storyManager)
    {
       $this->security = $security;
       $this->storyManager = $storyManager;
    }

    /**
     * @Route("/public/stories", name="stories_list", methods={"GET"})
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
     * @Route("/public/stories/latest_ten", name="stories_latest_ten", methods={"GET"})
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
     * @Route("/public/stories/top_ten", name="stories_top_ten", methods={"GET"})
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
     * @Route("/public/stories/{id}", name="story_view", methods={"GET"}, requirements={"id"="\d+"})
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
     * @Route("/stories", name="story_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        // we are treating the data from the request with symfony's "processing form" 
        // https://symfony.com/doc/current/forms.html#processing-forms

        // get the data submitted by the front
        $submittedData = json_decode($request->getContent(), true);

        // create an object Story
        $story = new Story();

        // set the author of the story = connected user
        $story->setAuthor($this->security->getUser());

        // instanciate the form = specifies what data we are supposed to get for the Story
        $form = $this->createForm(StoryType::class, $story);

        // submit the submitted data to the form :
        // - binds the submitted data to the Story object (calls the setters for each field in StoryType)
        // - launches data validation on the story object
        // TODO : asserts

        // false = if one field is missing in the submitted data, it will be "null" in the entity
        $form->submit($submittedData, false);
        // updates the Story object


        // if data has been submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($story);
            // At this stage we created a new Story entity, with its title, picFile, category, status, difficulty, synopsis (cf StoryType) + auto-generated properties id, created at, updated at

            // We are still missing the firstScene for our StoryEntity
            // Also we did not treat the scenes data sent by the front
            // We will do all that with the storyManager service = gets the first scene for the Story, and creates scenes and transitions from the front data
            // Get scenes data (as arrays) so we can pass it as argument for the storyManager
            $scenesData = $submittedData['scenes'];

            // service storyManager :
            // 1) register all the scenes in the database
            // 2) register the transitions in the database

            $this->storyManager->createScenes($story, $scenesData);

            // the storyManager has set all the missing data we need in the DB to create a functionnal story
            // TODO suppr la version precedente de l'histoire si elle existe deja en BDD ?
            $manager->flush();

            return $this->json(
                ["success" => true],
                Response::HTTP_OK
            );
        }

        return $this->json(
            $form->getErrors(true),
            Response::HTTP_BAD_REQUEST,
        );
    }
}



