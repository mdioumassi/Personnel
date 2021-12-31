<?php

namespace App\Entity;

use App\Repository\PersonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonsRepository::class)
 */
class Persons
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=Persons::class, inversedBy="subordinate")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $persons;

    /**
     * @ORM\OneToMany(targetEntity=Persons::class, mappedBy="persons", orphanRemoval=true)
     */
    private $subordinate;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    public function __construct()
    {
        $this->subordinate = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getPersons(): ?self
    {
        return $this->persons;
    }

    public function setPersons(?self $persons): self
    {
        $this->persons = $persons;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubordinate(): Collection
    {
        return $this->subordinate;
    }

    public function addSubordinate(self $subordinate): self
    {
        if (!$this->subordinate->contains($subordinate)) {
            $this->subordinate[] = $subordinate;
            $subordinate->setPersons($this);
        }

        return $this;
    }

    public function removeSubordinate(self $subordinate): self
    {
        if ($this->subordinate->removeElement($subordinate)) {
            // set the owning side to null (unless already changed)
            if ($subordinate->getPersons() === $this) {
                $subordinate->setPersons(null);
            }
        }
        return $this;
    }

    public function __toString()
    {
        return $this->getFirstname()[0] .'.  '.$this->getLastname(). '-'.ucfirst($this->getPost());
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}

