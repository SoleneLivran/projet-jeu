<?php

namespace App\Entity;

use App\Repository\PlaceTypeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlaceTypeRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class PlaceType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"places:list", "place:view", "story:view", "next_scene", "place_types:list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"places:list", "place:view", "story:view", "next_scene", "place_types:list"})
     * @Assert\Regex(
     *     pattern="/^[\sa-zA-Z0-9ÀÂÇÈÉÊËÎÔÙÛàâçèéêëîôöùû\.\(\)\[\]\'\-,;:\/!\?]+$/",
     *     match=true,
     *     message="Les caractères spéciaux ne sont pas autorisés"
     * ) 
     * @Assert\Length(
     * min = 2,
     * max = 60,
     * minMessage = "The name must be at least {{ limit }} characters long",
     * maxMessage = "The name cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "default_place_type"})
     * @Groups({"story:view", "next_scene", "place_types:list"})
     * @Assert\Length(
     * min = 2,
     * max = 80,
     * minMessage = "The pictureFile must be at least {{ limit }} characters long",
     * maxMessage = "The pictureFile cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $pictureFile = "default_place_type";

    /**
     * @ORM\ManyToMany(targetEntity=Place::class, mappedBy="placeType")
     */
    private $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
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

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->addPlaceType($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            $place->removePlaceType($this);
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
