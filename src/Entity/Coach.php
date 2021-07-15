<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoachRepository::class)
 */
class Coach
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
     * @ORM\OneToOne(targetEntity=Media::class, inversedBy="coach", cascade={"persist", "remove"})
     */
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity=Video::class, inversedBy="coach")
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity=Studio::class, mappedBy="coach")
     */
    private $studio;

    public function __construct()
    {
        $this->studio = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        $this->video = $video;

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
            $studio->setCoach($this);
        }

        return $this;
    }

    public function removeStudio(Studio $studio): self
    {
        if ($this->studio->removeElement($studio)) {
            // set the owning side to null (unless already changed)
            if ($studio->getCoach() === $this) {
                $studio->setCoach(null);
            }
        }

        return $this;
    }
}
