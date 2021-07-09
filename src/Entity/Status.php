<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status
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
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="status")
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity=Studio::class, mappedBy="statuseses")
     */
    private $studio;


    public function __construct()
    {
        $this->video = new ArrayCollection();
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
            $video->setStatus($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->video->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getStatus() === $this) {
                $video->setStatus(null);
            }
        }

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
            $studio->setStatus($this);
        }

        return $this;
    }

    public function removeStudio(Studio $studio): self
    {
        if ($this->studio->removeElement($studio)) {
            // set the owning side to null (unless already changed)
            if ($studio->getStatus() === $this) {
                $studio->setStatus(null);
            }
        }

        return $this;
    }



}
