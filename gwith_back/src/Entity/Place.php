<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
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
     * @ORM\Column(type="datetime")
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
     * @ORM\ManyToMany(targetEntity=PlaceType::class, inversedBy="places")
     */
    private $placeTypeId;

    /**
     * @ORM\OneToMany(targetEntity=Scene::class, mappedBy="placeId", orphanRemoval=true)
     */
    private $scenes;

    public function __construct()
    {
        $this->placeTypeId = new ArrayCollection();
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

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
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

    /**
     * @return Collection|PlaceType[]
     */
    public function getPlaceTypeId(): Collection
    {
        return $this->placeTypeId;
    }

    public function addPlaceTypeId(PlaceType $placeTypeId): self
    {
        if (!$this->placeTypeId->contains($placeTypeId)) {
            $this->placeTypeId[] = $placeTypeId;
        }

        return $this;
    }

    public function removePlaceTypeId(PlaceType $placeTypeId): self
    {
        if ($this->placeTypeId->contains($placeTypeId)) {
            $this->placeTypeId->removeElement($placeTypeId);
        }

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
            $scene->setPlaceId($this);
        }

        return $this;
    }

    public function removeScene(Scene $scene): self
    {
        if ($this->scenes->contains($scene)) {
            $this->scenes->removeElement($scene);
            // set the owning side to null (unless already changed)
            if ($scene->getPlaceId() === $this) {
                $scene->setPlaceId(null);
            }
        }

        return $this;
    }
}
