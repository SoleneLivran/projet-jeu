<?php

namespace App\Service;

use App\Entity\Action;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Scene;
use App\Entity\Story;
use App\Entity\Transition;
use Doctrine\ORM\EntityManagerInterface;

class StoryManager
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
       $this->manager = $manager;
    }

    public function createScenes(Story $story, array $scenesData) {
        //===========SCENES===============
        // array to keep track of the scenes we are about to create
        $scenes = [];

        // for each scene in the scenes data from the front, we create a Scene entity
        foreach ($scenesData as $sceneData) {
            $scene = new Scene();

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
            $key = $sceneData['id'];
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

                // get the action and set it in the transition
                $action = $this->manager->getReference(Action::class, $transitionData['action']);
                $transition->setAction($action);

                // nextScene :
                // get the front id of the nextscene
                $nextSceneFrontId = $transitionData['nextScene'];
                // in the array with all the scenes (front scenes), select the relevant scene by its front id
                $nextScene = $scenes[$nextSceneFrontId];
                // set this scene as transition's nextScene
                $transition->setNextScene($nextScene);

                // currentScene :
                // get the front id of the current scene (the one we are iterating on)
                $currentSceneFrontId = $sceneData['id'];
                // in the array with all the scenes (front scenes), select the relevant scene by its front id
                $currentScene = $scenes[$currentSceneFrontId];
                // set this scene as transition's currentScene
                $transition->setCurrentScene($currentScene);

                $this->manager->persist($transition);
            }
        }
    }
}