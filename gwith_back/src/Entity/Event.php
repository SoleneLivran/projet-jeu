<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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
     * @ORM\Column(type="string", length=255)
     * @ORM\Column(type="string", options={"default": ""})
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\Column(type="string", options={"default": ""})
     */
    private $soundFile;

    /**
     * @ORM\Column(type="boolean")
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isEnd;

    /**
     * @ORM\ManyToOne(targetEntity=EventType::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=true)
     */
    private $eventTypeId;

    /**
     * @ORM\OneToMany(targetEntity=Scene::class, mappedBy="eventId", orphanRemoval=true)
     */
    private $scenes;

    public function __construct()
    {
        $this->scenes = new ArrayCollection();
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

    public function getEventTypeId(): ?EventType
    {
        return $this->eventTypeId;
    }

    public function setEventTypeId(?EventType $eventTypeId): self
    {
        $this->eventTypeId = $eventTypeId;

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
            $scene->setEventId($this);
        }

        return $this;
    }

    public function removeScene(Scene $scene): self
    {
        if ($this->scenes->contains($scene)) {
            $this->scenes->removeElement($scene);
            // set the owning side to null (unless already changed)
            if ($scene->getEventId() === $this) {
                $scene->setEventId(null);
            }
        }

        return $this;
    }
}
