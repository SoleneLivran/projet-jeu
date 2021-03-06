<?php

namespace App\Service;

use App\Entity\Action;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Scene;
use App\Entity\Story;
use App\Entity\Transition;
use App\Repository\StoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class StoryManager
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    private $repository;

    public function __construct(EntityManagerInterface $manager, StoryRepository $repository)
    {
       $this->manager = $manager;
       $this->repository = $repository;
    }

    public function createScenes(Story $story, array $scenesData)
    {
        //===========SCENES===============
        // delete previously registered scenes, if any, for the Story update
        $previousVersionScenes = $story->getScenes();
        foreach ($previousVersionScenes as $previousVersionScene) {
            $this->manager->remove($previousVersionScene);
        }

        // array to keep track of the scenes we are about to create
        $scenes = [];

        // for each scene in the scenes data from the front, we create a Scene entity
        foreach ($scenesData as $sceneData) {
            $scene = new Scene();

            // get the front ID and set it in the scene
            $frontId = $sceneData['reference'];
            $scene->setReference($frontId);

            // get the place and set it in the scene
            $place = $this->manager->getReference(Place::class, $sceneData['place']);
            $scene->setPlace($place);

            // get the event and set it in the scene
            $event = $this->manager->getReference(Event::class, $sceneData['event']);
            $scene->setEvent($event);

            // set the story property for the scene = id of the current story
            $scene->setStory($story);

            // now we have all we need for one scene : persist
            $this->manager->persist($scene);

            // keep track of the created scene and their front id
            $key = $sceneData['reference'];
            $scenes[$key] = $scene;
            // = array containing the scene id (front id) as key and the scene as value
        }

        //===========FIRST SCENE===============
        // from the scenes, we get the scene with a "front" id 0
        // ie the first scene of the story created in the story creation tool
        // and set it as the firstScene of our story
        $story->setFirstScene($scenes[0]);

        //===========TRANSITIONS===============
        // for each scene...
        foreach ($scenesData as $sceneData) {
            // ...we iterate over its transitions
            foreach ($sceneData['transitions'] as $transitionData) {
                // for each transition, we create a Transition entity
                $transition = new Transition();

                // Register the transitions' nextSceneRef
                $nextSceneRef = $transitionData['nextSceneRef'];
                $transition->setNextSceneRef($nextSceneRef);

                // get the action and set it in the transition
                $action = $this->manager->getReference(Action::class, $transitionData['action']);
                $transition->setAction($action);

                // nextScene :
                // get the front id of the nextscene
                $nextSceneFrontId = $transitionData['nextSceneRef'];
                // in the array with all the scenes (front scenes), select the relevant scene by its front id
                if (isset($scenes[$nextSceneFrontId])) {
                    $nextScene = $scenes[$nextSceneFrontId];
                    // set this scene as transition's nextScene
                    $transition->setNextScene($nextScene);
                }
                // currentScene :
                // get the front id of the current scene (the one we are iterating on)
                $currentSceneFrontId = $sceneData['reference'];
                // in the array with all the scenes (front scenes), select the relevant scene by its front id
                $currentScene = $scenes[$currentSceneFrontId];
                // set this scene as transition's currentScene
                $transition->setCurrentScene($currentScene);

                $this->manager->persist($transition);
            }
        }
    }

    public function checkStory(Story $story) : array
    {
        $errors = [];

        if(!$this->repository->doesStoryHasFirstScene($story)) {
            $errors[] = "L'histoire n'a pas de scène de début";
        }

        if(!$this->repository->doesStoryHasEnd($story)) {
            $errors[] = "L'histoire doit avoir au moins une fin";
        }

        if(!$this->repository->doNonEndScenesHaveTransitions($story)) {
            $errors[] = "Toutes les scènes qui ne sont pas la fin de l'histoire doivent avoir une transition";
        }

        if(!$this->repository->doTransitionsHaveNextScene($story)) {
            $errors[] = "Au moins une transition n'a pas de nextScene";
        }

        if(!$this->repository->doesStoryHasCategory($story)) {
            $errors[] = "Choisir une catégorie pour l'histoire";
        }

        return $errors;
    }
}
