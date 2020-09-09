<?php

namespace App\Entity;

use App\Repository\SceneRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SceneRepository::class)
 */
class Scene
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
     * @ORM\ManyToOne(targetEntity=Transition::class, mappedBy="currentSceneId")
     */
    private $transitions;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="scenes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="scenes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    public function __construct()
    {
        $this->transitions = new ArrayCollection();
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
     * @return Collection|Transition[]
     */
    public function getTransitions(): Collection
    {
        return $this->transitions;
    }

    public function addTransition(Transition $transition): self
    {
        if (!$this->transitions->contains($transition)) {
            $this->transitions[] = $transition;
            $transition->addCurrentScene($this);
        }

        return $this;
    }

    public function removeTransition(Transition $transition): self
    {
        if ($this->transitions->contains($transition)) {
            $this->transitions->removeElement($transition);
            $transition->removeCurrentScene($this);
        }

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->placeId = $place;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->eventId = $event;

        return $this;
    }
}
