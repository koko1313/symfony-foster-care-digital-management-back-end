<?php

namespace App\Entity;

use App\Entity\BaseEntities\Person;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChildRepository")
 */
class Child extends Person
{
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="10")
     */
    protected $egn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Family", inversedBy="children")
     */
    private $family;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EmployeeOepg", inversedBy="children")
     */
    private $warden;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getWarden(): ?EmployeeOepg
    {
        return $this->warden;
    }

    public function setWarden(?EmployeeOepg $warden): self
    {
        $this->warden = $warden;

        return $this;
    }
}
