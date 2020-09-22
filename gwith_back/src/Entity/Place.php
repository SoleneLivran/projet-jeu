<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"places:list", "place:view", "story:view", "next_scene", "story:editable"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"places:list", "place:view", "story:view", "next_scene"})
     * @Assert\Regex(
     *     pattern="/^[\sa-zA-Z0-9ÀÂÇÈÉÊËÎÔÙÛàâçèéêëîôöùû\.\(\)\[\]\'\-,;:\/!\?]+$/",
     *     match=true,
     *     message="Les caractères spéciaux ne sont pas autorisés"
     * )
     * @Assert\Length(
     * min = 2,
     * max = 50,
     * minMessage = "The name must be at least {{ limit }} characters long",
     * maxMessage = "The name cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"places:list", "place:view", "story:view", "next_scene"})
     * @Assert\Regex(
     *     pattern="/^[\sa-zA-Z0-9ÀÂÇÈÉÊËÎÔÙÛàâçèéêëîôöùû\.\(\)\[\]\'\-,;:\/!\?]+$/",
     *     match=true,
     *     message="Les caractères spéciaux ne sont pas autorisés"
     * )
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
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "default_place"})
     * @Groups({"places:list", "place:view", "story:view", "next_scene"})
     * @Assert\Length(
     * min = 2,
     * max = 2000,
     * minMessage = "The pictureFile must be at least {{ limit }} characters long",
     * maxMessage = "The pictureFile cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $pictureFile = "default_place";

    /**
     * @ORM\Column(type="string", length=255, options={"default": "default_place"})
     * @Groups({"place:view", "story:view", "next_scene"})
     * @Assert\Length(
     * min = 2,
     * max = 2000,
     * minMessage = "The soundFile must be at least {{ limit }} characters long",
     * maxMessage = "The soundFile cannot be longer than {{ limit }} characters",
     * allowEmptyString = false
     * )
     */
    private $soundFile = "default_place";

    /**
     * @ORM\ManyToMany(targetEntity=PlaceType::class, inversedBy="places")
     * @Groups({"places:list", "place:view", "story:view", "next_scene"})
     */
    private $placeType;

    /**
     * @ORM\OneToMany(targetEntity=Scene::class, mappedBy="place", orphanRemoval=true)
     */
    private $scenes;

    public function __construct()
    {
        $this->placeType = new ArrayCollection();
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
    public function getPlaceType(): Collection
    {
        return $this->placeType;
    }

    public function addPlaceType(PlaceType $placeType): self
    {
        if (!$this->placeType->contains($placeType)) {
            $this->placeType[] = $placeType;
        }

        return $this;
    }

    public function removePlaceType(PlaceType $placeType): self
    {
        if ($this->placeType->contains($placeType)) {
            $this->placeType->removeElement($placeType);
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
            $scene->setPlace($this);
        }

        return $this;
    }

    public function removeScene(Scene $scene): self
    {
        if ($this->scenes->contains($scene)) {
            $this->scenes->removeElement($scene);
            // set the owning side to null (unless already changed)
            if ($scene->getPlace() === $this) {
                $scene->setPlace(null);
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
