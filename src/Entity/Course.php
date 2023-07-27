<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titleCourse = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: Programe::class)]
    private Collection $programes;

    public function __construct()
    {
        $this->programes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleCourse(): ?string
    {
        return $this->titleCourse;
    }

    public function setTitleCourse(string $titleCourse): static
    {
        $this->titleCourse = $titleCourse;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
            $programe->setCourse($this);
        }

        return $this;
    }

    public function removePrograme(Programe $programe): static
    {
        if ($this->programes->removeElement($programe)) {
            // set the owning side to null (unless already changed)
            if ($programe->getCourse() === $this) {
                $programe->setCourse(null);
            }
        }

        return $this;
    }
}
