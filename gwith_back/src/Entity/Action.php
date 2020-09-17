<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 */
class Action
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"actions:list", "action:view", "story:view", "next_scene"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"actions:list", "action:view", "story:view", "next_scene"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"actions:list", "action:view", "story:view", "next_scene"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     * @Groups({"story:view", "action:view", "next_scene"})
     */
    private $soundFile = "";

    /**
     * @ORM\ManyToOne(targetEntity=ActionType::class, inversedBy="actions")
     * @Groups({"actions:list", "action:view", "story:view", "next_scene"})
     */
    private $actionType;

    /**
     * @ORM\OneToMany(targetEntity=Transition::class, mappedBy="action", orphanRemoval=true)
     */
    private $transitions;

    public function __construct()
    {
        $this->transitions = new ArrayCollection();
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

    public function getSoundFile(): ?string
    {
        return $this->soundFile;
    }

    public function setSoundFile(string $soundFile): self
    {
        $this->soundFile = $soundFile;

        return $this;
    }

    public function getActionType(): ?ActionType
    {
        return $this->actionType;
    }

    public function setActionType(?ActionType $actionType): self
    {
        $this->actionType = $actionType;

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
            $transition->setAction($this);
        }

        return $this;
    }

    public function removeTransition(Transition $transition): self
    {
        if ($this->transitions->contains($transition)) {
            $this->transitions->removeElement($transition);
            // set the owning side to null (unless already changed)
            if ($transition->getAction() === $this) {
                $transition->setAction(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
   
   

}
