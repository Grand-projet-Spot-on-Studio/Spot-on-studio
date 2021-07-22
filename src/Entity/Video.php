<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

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
     * @ORM\Column(type="string", nullable=true)
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
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="video")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="video")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="video", cascade={"persist", "remove"})
     */
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="video")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $coach;

    /**
     * @ORM\ManyToOne(targetEntity=Studio::class, inversedBy="video")
     */
    private $studio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;




    public function __construct()
    {
        $this->media = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
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

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration): self
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


    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->media->contains($media)) {
            $this->media[] = $media;
            $media->setVideo($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->media->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getVideo() === $this) {
                $media->setVideo(null);
            }
        }

        return $this;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getStudio(): ?Studio
    {
        return $this->studio;
    }

    public function setStudio(?Studio $studio): self
    {
        $this->studio = $studio;

        return $this;
    }

    public function getcreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setcreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->createdAt = $CreatedAt;

        return $this;
    }

}
