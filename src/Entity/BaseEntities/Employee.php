<?php

namespace App\Entity\BaseEntities;

use App\Entity\Position;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Employee extends User
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Position")
     */
    protected $position;

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
