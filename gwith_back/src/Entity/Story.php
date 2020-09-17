<?php

namespace App\Entity;

use App\Repository\StoryRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StoryRepository::class)
 */
class Story
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"stories:list", "story:view"})
     */
    private $id;

    /**
     * @ORM\Column(name="createdAt", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"stories:list", "story:view"})
     *
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="smallint", options={"default": 2})
     * @Groups({"story:view"})
     */
    private $status = 2;

    /**
     * @ORM\Column(type="smallint", options={"default": 0})
     * @Groups({"stories:list", "story:view"})
     */
    private $rating = 0;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"stories:list", "story:view"})
     */
    private $difficulty;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"story:view"})
     */
    private $synopsis;

    /**
     * @ORM\ManyToOne(targetEntity=AppUser::class, inversedBy="stories")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"stories:list", "story:view"})
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=StoryCategory::class, inversedBy="stories")
     * @Groups({"stories:list", "story:view"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="story", orphanRemoval=true)
     * @Groups({"story:view"})
     */
    private $ratings;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "Sans Titre"})
     * @Groups({"stories:list", "story:view"})
     */
    private $title = "Sans Titre";

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     * @Groups({"stories:list", "story:view"})
     */
    private $pictureFile = "";

    /**
     * @ORM\OneToOne(targetEntity=Scene::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"story:view"})
     */
    private $firstScene;

    /**
     * @ORM\OneToMany(targetEntity=Scene::class, mappedBy="story", orphanRemoval=true)
     */
    private $scenes;

   
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->ratings = new ArrayCollection();
        $this->scenes = new ArrayCollection();
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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getAuthor(): ?AppUser
    {
        return $this->author;
    }

    public function setAuthor(?AppUser $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?StoryCategory
    {
        return $this->category;
    }

    public function setCategory(?StoryCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setStory($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getStory() === $this) {
                $rating->setStory(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getFirstScene(): ?Scene
    {
        return $this->firstScene;
    }

    public function setFirstScene(Scene $firstScene): self
    {
        $this->firstScene = $firstScene;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
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
            $scene->setStory($this);
        }

        return $this;
    }

    public function removeScene(Scene $scene): self
    {
        if ($this->scenes->contains($scene)) {
            $this->scenes->removeElement($scene);
            // set the owning side to null (unless already changed)
            if ($scene->getStory() === $this) {
                $scene->setStory(null);
            }
        }

        return $this;
    }

}
