<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $maxParticipant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startingDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Formation $formation = null;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Programe::class)]
    private Collection $programes;

    #[ORM\ManyToMany(targetEntity: Intern::class, mappedBy: 'Session')]
    private Collection $interns;

    public function __construct()
    {
        $this->programes = new ArrayCollection();
        $this->interns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxParticipant(): ?int
    {
        return $this->maxParticipant;
    }

    public function setMaxParticipant(int $maxParticipant): static
    {
        $this->maxParticipant = $maxParticipant;

        return $this;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    public function setStartingDate(\DateTimeInterface $startingDate): static
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, Programe>
     */
    public function getProgrames(): Collection
    {
        return $this->programes;
    }

    public function addPrograme(Programe $programe): static
    {
        if (!$this->programes->contains($programe)) {
            $this->programes->add($programe);
            $programe->setSession($this);
        }

        return $this;
    }

    public function removePrograme(Programe $programe): static
    {
        if ($this->programes->removeElement($programe)) {
            // set the owning side to null (unless already changed)
            if ($programe->getSession() === $this) {
                $programe->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Intern>
     */
    public function getInterns(): Collection
    {
        return $this->interns;
    }

    public function addIntern(Intern $intern): static
    {
        if (!$this->interns->contains($intern)) {
            $this->interns->add($intern);
            $intern->addSession($this);
        }

        return $this;
    }

    public function removeIntern(Intern $intern): static
    {
        if ($this->interns->removeElement($intern)) {
            $intern->removeSession($this);
        }

        return $this;
    }

    public function __toString()  {

        return "test";
        
    }
}
