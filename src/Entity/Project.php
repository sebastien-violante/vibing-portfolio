<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 150)]
    private ?string $title = null;

    #[ORM\Column(length: 160, unique: true)]
    #[Assert\NotBlank]
    private ?string $slug = null;

    #[ORM\Column(length: 300)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 300)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description = null;

    /** @var string[] */
    #[ORM\Column(type: Types::JSON)]
    private array $stack = [];

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $githubUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $demoUrl = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $projectDate = null;

    #[ORM\Column]
    private int $position = 0;

    #[ORM\Column]
    private bool $isPublished = false;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    /** @var Collection<int, ProjectImage> */
    #[ORM\OneToMany(targetEntity: ProjectImage::class, mappedBy: 'project', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $slug): static { $this->slug = $slug; return $this; }

    public function getShortDescription(): ?string { return $this->shortDescription; }
    public function setShortDescription(string $v): static { $this->shortDescription = $v; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $v): static { $this->description = $v; return $this; }

    public function getStack(): array { return $this->stack; }
    public function setStack(array $stack): static { $this->stack = $stack; return $this; }

    public function getGithubUrl(): ?string { return $this->githubUrl; }
    public function setGithubUrl(?string $v): static { $this->githubUrl = $v; return $this; }

    public function getDemoUrl(): ?string { return $this->demoUrl; }
    public function setDemoUrl(?string $v): static { $this->demoUrl = $v; return $this; }

    public function getProjectDate(): ?\DateTimeImmutable { return $this->projectDate; }
    public function setProjectDate(\DateTimeImmutable $v): static { $this->projectDate = $v; return $this; }

    public function getPosition(): int { return $this->position; }
    public function setPosition(int $v): static { $this->position = $v; return $this; }

    public function isPublished(): bool { return $this->isPublished; }
    public function setIsPublished(bool $v): static { $this->isPublished = $v; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }

    /** @return Collection<int, ProjectImage> */
    public function getImages(): Collection { return $this->images; }

    public function addImage(ProjectImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProject($this);
        }
        return $this;
    }

    public function removeImage(ProjectImage $image): static
    {
        $this->images->removeElement($image);
        return $this;
    }

    public function __toString(): string { return $this->title ?? ''; }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}