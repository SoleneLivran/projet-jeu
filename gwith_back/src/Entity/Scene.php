<?php

namespace App\Entity;

use App\Repository\SceneRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SceneRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Scene
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"story:view", "next_scene"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Transition::class, mappedBy="currentScene")
     * @Groups({"story:view", "next_scene"})
     */
    private $transitions;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="scenes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"story:view", "next_scene"})
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="scenes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"story:view", "next_scene"})
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=Story::class, inversedBy="scenes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $story;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reference;

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
            $transition->setCurrentScene($this);
        }

        return $this;
    }

    public function removeTransition(Transition $transition): self
    {
        if ($this->transitions->contains($transition)) {
            $this->transitions->removeElement($transition);
            // set the owning side to null (unless already changed)
            if ($transition->getCurrentScene() === $this) {
                $transition->setCurrentScene(null);
            }
        }

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    
    
    public function getStory(): ?Story
    {
        return $this->story;
    }

    public function setStory(?Story $story): self
    {
        $this->story = $story;

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

    public function __toString()
    {
        $sceneId = $this->getId();
        $placeName = $this->getPlace()->getName();
        $eventName = $this->getEvent()->getName();
        return "#" . $sceneId . " " . $placeName . " + " . $eventName;
    }

    public function getReference(): ?int
    {
        return $this->reference;
    }

    public function setReference(?int $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
}
