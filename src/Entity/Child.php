<?php

namespace App\Entity;

use App\Entity\BaseEntities\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChildRepository")
 */
class Child extends Person
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Family", inversedBy="children")
     */
    private $familyId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyId(): ?Family
    {
        return $this->familyId;
    }

    public function setFamilyId(?Family $familyId): self
    {
        $this->familyId = $familyId;

        return $this;
    }
}
