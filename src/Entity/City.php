<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubRegion", inversedBy="cities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subRegion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="cities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @JMS\Exclude()
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="city")
     */
    private $people;

    public function __construct()
    {
        $this->people = new ArrayCollection();
    }


    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;

        return $this;
    }

    public function getSubRegion() {
        return $this->subRegion;
    }

    public function setSubRegion(?SubRegion $subRegion) {
        $this->subRegion = $subRegion;

        return $this;
    }

    public function getRegion() {
        return $this->region;
    }

    public function setRegion(?Region $region) {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setCity($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getCity() === $this) {
                $person->setCity(null);
            }
        }

        return $this;
    }

}
