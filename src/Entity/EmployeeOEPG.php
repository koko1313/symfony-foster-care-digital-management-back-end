<?php

namespace App\Entity;

use App\Entity\BaseEntities\Employee;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeOEPGRepository")
 * @JMS\ExclusionPolicy("none")
 */
class EmployeeOEPG extends Employee
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Family", mappedBy="warden")
     * @JMS\Exclude()
     */
    protected $families;

    public function __construct()
    {
        parent::__construct();
        $this->families = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    /**
     * @return Collection|Family[]
     */
    public function getFamilies(): Collection
    {
        return $this->families;
    }

    public function addFamily(Family $family): self
    {
        if (!$this->families->contains($family)) {
            $this->families[] = $family;
            $family->setWarden($this);
        }

        return $this;
    }

    public function removeFamily(Family $family): self
    {
        if ($this->families->contains($family)) {
            $this->families->removeElement($family);
            // set the owning side to null (unless already changed)
            if ($family->getWarden() === $this) {
                $family->setWarden(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Child[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Child $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setWarden($this);
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getWarden() === $this) {
                $child->setWarden(null);
            }
        }

        return $this;
    }
}
