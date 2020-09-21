<?php

namespace App\Controller;

use App\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Story;
use App\Form\StoryRatingType;
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
        } 
        elseif ($request->query->has('story_difficulty')) {
                $storyDifficulty = $request->query->get('story_difficulty');
                $stories = $repository->findAllByDifficulty($storyDifficulty);
        }
        else {
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
     * @Route("/public/stories/latest_five", name="stories_latest_five", methods={"GET"})
     */
    public function listLatestFive(StoryRepository $repository)
    {
        $stories = $repository->findLatestFive();
        return $this->json(
            $stories,
            200,
            [],
            ["groups" => ["stories:list"]]
        );
    }

    /**
     * @Route("/public/stories/top_five", name="stories_top_five", methods={"GET"})
     */
    public function listTopFive(StoryRepository $repository)
    {
        $stories = $repository->findTopFive();
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
     * @Route("/stories/{id}/rating", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function storyRating(Request $request, Story $story)
    {
        $ratingData = json_decode($request->getContent(), true);
        $rating = new Rating();
        $rating->setStory($story);
        
        $form = $this->createForm(StoryRatingType::class, $rating);
        // if false, sets the value of a data to null into the database
        $form->submit($ratingData, false);

         if ($form->isSubmitted() && $form->isValid()) {
            
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($rating);
            $manager->flush();
        
            return $this->json(
                [
                    "success" => true
                ],
                Response::HTTP_OK
            ); 
        }

        return $this->json(
            [
                "success" => false,
                "errors" => "Une erreur s'est produite lors de l'affectation d'une note à l'histoire"
            ],
            Response::HTTP_BAD_REQUEST
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

        $story->setStatus(Story::STATUS_DRAFT);

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
            $manager->flush();

            return $this->json(
                [ 'story_id' => $story->getId() ],
                Response::HTTP_OK
            );
        }

        return $this->json(
            $form->getErrors(true),
            Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @Route("/stories/{id}", name="story_update", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function update(Story $story, Request $request)
    {
        if ($story->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can\'t edit another author\'s story!');
        }

        $submittedData = json_decode($request->getContent(), true);

        $story->setStatus(Story::STATUS_DRAFT);

        $form = $this->createForm(StoryType::class, $story);

        // TODO : asserts

        $form->submit($submittedData, false);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $scenesData = $submittedData['scenes'];
            
            $this->storyManager->createScenes($story, $scenesData);
            $manager->flush();

            return $this->json(
                [ 'story_id' => $story->getId() ],
                Response::HTTP_OK
            );
        }

        return $this->json(
            $form->getErrors(true),
            Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @Route("/stories/{id}/editable", name="story_editable", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function loadEditableStory(StoryRepository $repository, Story $story)
    {
        if ($story->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can\'t get another author\'s story\'s work file!');
        }

        $editableStory = $repository->find($story);
        return $this->json(
            $editableStory,
            200,
            [],
            ["groups" => ["story:editable"]]
        );
    }

    /**
     * @Route("/stories/{id}", name="story_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Story $story)
    {
        if ($story->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can\'t delete another author\'s story!');
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($story);

        $manager->flush();

        return $this->json(
            [ 'id' => $story->getId() ],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/stories/{id}/publish", name="story_publish", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function publish(Story $story)
    {
        if ($story->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can\'t publish another author\'s story!');
        }

        if ($this->storyManager->storyErrors($story) <= 0) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($story); // ??

            $manager->flush();

            return $this->json(
                [ 'id' => $story->getId() ],
                Response::HTTP_OK
            );
        }

        return $this->json(
            [
                "success" => false,
                "errors" => "The story contains errors and cannot be published"
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}



