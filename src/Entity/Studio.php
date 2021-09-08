<?php

namespace App\Entity;

use App\Repository\StudioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @ORM\Entity(repositoryClass=StudioRepository::class)
 */
class Studio
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="studio")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $user_employed;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="studio")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $user_customer;


    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="studio")
     */
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="studio")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $status;


    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="studio")
     */
    private $video;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slugName;

    /**
     * @ORM\ManyToMany(targetEntity=Coach::class, mappedBy="studio")
     */
    private $coaches;



    public function __construct()
    {
        $this->user_customer = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->video = new ArrayCollection();
        $this->coaches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(?int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getUserEmployed()
    {
        return $this->user_employed;
    }

    public function setUserEmployed( $user_employed): self
    {
        $this->user_employed = $user_employed;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserCustomer()
    {
        return $this->user_customer;
    }

    public function addUserCustomer(User $userCustomer): self
    {
        if (!$this->user_customer->contains($userCustomer)) {
            $this->user_customer[] = $userCustomer;
        }

        return $this;
    }

    public function removeUserCustomer(User $userCustomer): self
    {
        $this->user_customer->removeElement($userCustomer);

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
            $media->setStudio($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->media->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getStudio() === $this) {
                $media->setStudio(null);
            }
        }

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
            $video->setStudio($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->video->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getStudio() === $this) {
                $video->setStudio(null);
            }
        }

        return $this;
    }

    public function getSlugName(): ?string
    {
        return $this->slugName;
    }

    public function setSlugName(?string $slugName): self
    {
        $this->slugName = $slugName;

        return $this;
    }

    /**
     * @return SluggerInterface
     */
    public function getSlugger(): SluggerInterface
    {
        return $this->slugger;
    }

    /**
     * @param SluggerInterface $slugger
     */
    public function setSlugger(SluggerInterface $slugger): void
    {
        $this->slugger = $slugger;
    }

    /**
     * @return Collection|Coach[]
     */
    public function getCoaches(): Collection
    {
        return $this->coaches;
    }

    public function addCoach(Coach $coach): self
    {
        if (!$this->coaches->contains($coach)) {
            $this->coaches[] = $coach;
            $coach->addStudio($this);
        }

        return $this;
    }

    public function removeCoach(Coach $coach): self
    {
        if ($this->coaches->removeElement($coach)) {
            $coach->removeStudio($this);
        }

        return $this;
    }


}
