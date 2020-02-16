<?php

namespace App\Entity;

use App\Entity\BaseEntities\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilyMemberRepository")
 */
class FamilyMember extends Person
{

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $relation; // relation to parent (son, daughter, cousin, ...)

    /**
     * @ORM\Column(type="text")
     */
    protected $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Family", inversedBy="familyMembers")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $family;

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
    }

}
