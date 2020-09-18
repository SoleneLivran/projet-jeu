<?php

namespace App\Entity;

use App\Repository\TransitionRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransitionRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Transition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"story:view", "next_scene"})
     */
    private $id;

    /**
     * @ORM\Column(name="createdAt", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Scene::class, inversedBy="transitions")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $currentScene;

    /**
     * @ORM\ManyToOne(targetEntity=Scene::class)
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $nextScene;

    /**
     * @Groups({"story:editable"})
     */
    private $nextSceneRef;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="transitions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"story:view", "next_scene", "story:editable"})
     */
    private $action;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCurrentScene(): ?Scene
    {
        return $this->currentScene;
    }

    public function setCurrentScene(?Scene $currentScene): self
    {
        $this->currentScene = $currentScene;

        return $this;
    }

    public function getNextScene(): ?Scene
    {
        return $this->nextScene;
    }

    public function getNextSceneRef(): ?int
    {
        return $this->getNextScene() ? $this->getNextScene()->getFrontReference() : null;
    }

    public function setNextScene(?Scene $nextScene): self
    {
        $this->nextScene = $nextScene;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setaction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }



    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function updatedTimestamps(): void
    {
    $this->setUpdatedAt(new \DateTime('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    } 
}
