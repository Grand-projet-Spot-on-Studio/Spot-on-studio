<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_password;

    /**
     * @ORM\OneToMany(targetEntity=Studio::class, mappedBy="user_employed")
     */
    private $studio;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="user")
     */
    private $video;



    public function __construct()
    {
        $this->studio = new ArrayCollection();
        $this->video = new ArrayCollection();

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getToken(): ?bool
    {
        return $this->token;
    }

    public function setToken(?bool $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDatePassword(): ?\DateTimeInterface
    {
        return $this->date_password;
    }

    public function setDatePassword(?\DateTimeInterface $date_password): self
    {
        $this->date_password = $date_password;

        return $this;
    }

    /**
     * @return Collection|Studio[]
     */
    public function getStudio(): Collection
    {
        return $this->studio;
    }

    public function addStudio(Studio $studio): self
    {
        if (!$this->studio->contains($studio)) {
            $this->studio[] = $studio;
            $studio->setUserEmployed($this);
        }

        return $this;
    }

    public function removeStudio(Studio $studio): self
    {
        if ($this->studio->removeElement($studio)) {
            // set the owning side to null (unless already changed)
            if ($studio->getUserEmployed() === $this) {
                $studio->setUserEmployed(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
            $video->setUser($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->video->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getUser() === $this) {
                $video->setUser(null);
            }
        }

        return $this;
    }




}
