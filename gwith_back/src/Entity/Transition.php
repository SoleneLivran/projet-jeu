<?php

namespace App\Entity;

use App\Repository\TransitionRepository;
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
     * @ORM\Column(type="datetime")
     * @ORM\Column(name="createdAt", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Scene::class, inversedBy="transitions")
     */
    private $currentSceneId;

    /**
     * @ORM\ManyToOne(targetEntity=Scene::class, inversedBy="transitions")
     */
    private $nextSceneId;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="transitions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $actionId;

    public function __construct()
    {
        $this->currentSceneId = new ArrayCollection();
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
    public function getCurrentSceneId(): Collection
    {
        return $this->currentSceneId;
    }

    public function addCurrentSceneId(Scene $currentSceneId): self
    {
        if (!$this->currentSceneId->contains($currentSceneId)) {
            $this->currentSceneId[] = $currentSceneId;
        }

        return $this;
    }

    public function removeCurrentSceneId(Scene $currentSceneId): self
    {
        if ($this->currentSceneId->contains($currentSceneId)) {
            $this->currentSceneId->removeElement($currentSceneId);
        }

        return $this;
    }

    public function getNextSceneId(): ?Scene
    {
        return $this->nextSceneId;
    }

    public function setNextSceneId(?Scene $nextSceneId): self
    {
        $this->nextSceneId = $nextSceneId;

        return $this;
    }

    public function getActionId(): ?Action
    {
        return $this->actionId;
    }

    public function setActionId(?Action $actionId): self
    {
        $this->actionId = $actionId;

        return $this;
    }
}
