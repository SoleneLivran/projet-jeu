<?php

namespace App\Entity;

use App\Repository\EventRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"events:list", "event:view", "story:view", "next_scene", "story:editable"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"events:list", "event:view", "story:view", "next_scene"})
     * @Assert\Length(
     * min = 2,
     * max = 60,
     * minMessage = "The event must be at least {{ limit }} characters long",
     * maxMessage = "The event cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"events:list", "event:view", "story:view", "next_scene"})
     * @Assert\Length(
     * min = 2,
     * max = 2000,
     * minMessage = "The description must be at least {{ limit }} characters long",
     * maxMessage = "The description cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "default_event"})
     * @Groups({"events:list", "event:view", "story:view", "next_scene"})
     * @Assert\Length(
     * min = 2,
     * max = 2000,
     * minMessage = "The pictureFile must be at least {{ limit }} characters long",
     * maxMessage = "The pictureFile cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $pictureFile = "default_event";

    /**
     * @ORM\Column(type="string", length=255, options={"default": "default_event"})
     * @Groups({"event:view", "story:view", "next_scene"})
     * @Assert\Length(
     * min = 2,
     * max = 2000,
     * minMessage = "The soundFile must be at least {{ limit }} characters long",
     * maxMessage = "The soundFile cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $soundFile = "default_event";

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     * @Groups({"events:list", "event:view", "story:view", "next_scene"})
     */
    private $isEnd = false;

    /**
     * @ORM\ManyToOne(targetEntity=EventType::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"events:list", "event:view", "story:view", "next_scene"})
     */
    private $eventType;

    /**
     * @ORM\OneToMany(targetEntity=Scene::class, mappedBy="event", orphanRemoval=true)
     */
    private $scenes;

    public function __construct()
    {
        $this->scenes = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getPictureFile(): ?string
    {
        return $this->pictureFile;
    }

    public function setPictureFile(string $pictureFile): self
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    public function getSoundFile(): ?string
    {
        return $this->soundFile;
    }

    public function setSoundFile(string $soundFile): self
    {
        $this->soundFile = $soundFile;

        return $this;
    }

    public function getIsEnd(): ?bool
    {
        return $this->isEnd;
    }

    public function setIsEnd(bool $isEnd): self
    {
        $this->isEnd = $isEnd;

        return $this;
    }

    public function getEventType(): ?EventType
    {
        return $this->eventType;
    }

    public function setEventType(?EventType $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * @return Collection|Scene[]
     */
    public function getScenes(): Collection
    {
        return $this->scenes;
    }

    public function addScene(Scene $scene): self
    {
        if (!$this->scenes->contains($scene)) {
            $this->scenes[] = $scene;
            $scene->setEvent($this);
        }

        return $this;
    }

    public function removeScene(Scene $scene): self
    {
        if ($this->scenes->contains($scene)) {
            $this->scenes->removeElement($scene);
            // set the owning side to null (unless already changed)
            if ($scene->getEvent() === $this) {
                $scene->setEvent(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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
