<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[Vich\Uploadable]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    private ?string $fullName = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank]
    private ?string $jobTitle = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $bio = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $githubUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $linkedinUrl = null;

    #[Vich\UploadableField(mapping: 'profile_photos', fileNameProperty: 'photoFilename')]
    #[Assert\Image(maxSize: '5M', mimeTypes: ['image/jpeg', 'image/png', 'image/webp'])]
    private ?File $photoFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoFilename = null;

    #[Vich\UploadableField(mapping: 'profile_cv', fileNameProperty: 'cvFilename')]
    #[Assert\File(maxSize: '5M', mimeTypes: ['application/pdf'])]
    private ?File $cvFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cvFilename = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int { return $this->id; }

    public function getFullName(): ?string { return $this->fullName; }
    public function setFullName(string $v): static { $this->fullName = $v; return $this; }

    public function getJobTitle(): ?string { return $this->jobTitle; }
    public function setJobTitle(string $v): static { $this->jobTitle = $v; return $this; }

    public function getBio(): ?string { return $this->bio; }
    public function setBio(string $v): static { $this->bio = $v; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $v): static { $this->email = $v; return $this; }

    public function getGithubUrl(): ?string { return $this->githubUrl; }
    public function setGithubUrl(?string $v): static { $this->githubUrl = $v; return $this; }

    public function getLinkedinUrl(): ?string { return $this->linkedinUrl; }
    public function setLinkedinUrl(?string $v): static { $this->linkedinUrl = $v; return $this; }

    public function setPhotoFile(?File $file = null): void
    {
        $this->photoFile = $file;
        if ($file !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getPhotoFile(): ?File { return $this->photoFile; }

    public function getPhotoFilename(): ?string { return $this->photoFilename; }
    public function setPhotoFilename(?string $v): static { $this->photoFilename = $v; return $this; }

    public function setCvFile(?File $file = null): void
    {
        $this->cvFile = $file;
        if ($file !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getCvFile(): ?File { return $this->cvFile; }

    public function getCvFilename(): ?string { return $this->cvFilename; }
    public function setCvFilename(?string $v): static { $this->cvFilename = $v; return $this; }

    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }

    public function __toString(): string { return $this->fullName ?? 'Profil'; }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}