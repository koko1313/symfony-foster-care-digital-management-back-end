<?php

namespace App\Entity;

use App\Entity\BaseEntities\Employee;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeOEPGRepository")
 */
class EmployeeOEPG extends Employee
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Family", mappedBy="warden")
     */
    private $families;

    public function __construct()
    {
        parent::__construct();
        $this->families = new ArrayCollection();
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
}
