<?php

namespace App\Entity;

use App\Repository\TransitionRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransitionRepository::class)
 */
class Transition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
     */
    private $currentScene;

    /**
     * @ORM\ManyToOne(targetEntity=Scene::class, inversedBy="transitions")
     */
    private $nextScene;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="transitions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    public function __construct()
    {
        $this->currentSceneId = new ArrayCollection();
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

    /**
     * @return Collection|Scene[]
     */
    public function getCurrentScene(): Collection
    {
        return $this->currentScene;
    }

    public function addCurrentScene(Scene $currentScene): self
    {
        if (!$this->currentScene->contains($currentScene)) {
            $this->currentScene[] = $currentScene;
        }

        return $this;
    }

    public function removeCurrentScene(Scene $currentScene): self
    {
        if ($this->currentScene->contains($currentScene)) {
            $this->currentScene->removeElement($currentScene);
        }

        return $this;
    }

    public function getNextScene(): ?Scene
    {
        return $this->nextScene;
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
}
