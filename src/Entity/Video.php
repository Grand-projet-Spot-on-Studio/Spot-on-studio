<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberView;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sampling;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $timerSampling;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $difficulty;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $programmingDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $averageGrade;


    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="video")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Status::class, mappedBy="video")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="video")
     */
    private $media;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->status = new ArrayCollection();
        $this->media = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(?\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getNumberView(): ?int
    {
        return $this->numberView;
    }

    public function setNumberView(?int $numberView): self
    {
        $this->numberView = $numberView;

        return $this;
    }

    public function getSampling(): ?bool
    {
        return $this->sampling;
    }

    public function setSampling(?bool $sampling): self
    {
        $this->sampling = $sampling;

        return $this;
    }

    public function getTimerSampling(): ?\DateTimeInterface
    {
        return $this->timerSampling;
    }

    public function setTimerSampling(?\DateTimeInterface $timerSampling): self
    {
        $this->timerSampling = $timerSampling;

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

    public function getProgrammingDate(): ?\DateTimeInterface
    {
        return $this->programmingDate;
    }

    public function setProgrammingDate(?\DateTimeInterface $programmingDate): self
    {
        $this->programmingDate = $programmingDate;

        return $this;
    }

    public function getAverageGrade(): ?float
    {
        return $this->averageGrade;
    }

    public function setAverageGrade(?float $averageGrade): self
    {
        $this->averageGrade = $averageGrade;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setVideo($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getVideo() === $this) {
                $user->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Status[]
     */
    public function getStatus(): Collection
    {
        return $this->status;
    }

    public function addStatus(Status $status): self
    {
        if (!$this->status->contains($status)) {
            $this->status[] = $status;
            $status->setVideo($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        if ($this->status->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getVideo() === $this) {
                $status->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedia(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media[] = $medium;
            $medium->setVideo($this);
        }

        return $this;
    }

    public function removeMedia(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getVideo() === $this) {
                $medium->setVideo(null);
            }
        }

        return $this;
    }
}
