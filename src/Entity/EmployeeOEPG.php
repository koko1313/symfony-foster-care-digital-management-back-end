<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeOEPGRepository")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "employee_oepg" = "EmployeeOEPG"})
 */
class EmployeeOEPG extends User {

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Child", mappedBy="employeeOEPG")
     */
    private $child;

    public function __construct() {
        parent::__construct();
        $this->child = new ArrayCollection();
    }

    /**
     * @return Collection|Child[]
     */
    public function getChild(): Collection
    {
        return $this->child;
    }

    public function addChild(Child $child): self
    {
        if (!$this->child->contains($child)) {
            $this->child[] = $child;
            $child->setEmployeeOEPG($this);
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        if ($this->child->contains($child)) {
            $this->child->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getEmployeeOEPG() === $this) {
                $child->setEmployeeOEPG(null);
            }
        }

        return $this;
    }
}
