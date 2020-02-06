<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
abstract class Employee extends User
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Position", inversedBy="employees")
     */
    private $position;

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }
}
