<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 * @JMS\ExclusionPolicy("none")
 */
class Region {

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
     * @JMS\Exclude()
     * @ORM\OneToMany(targetEntity="App\Entity\SubRegion", mappedBy="region")
     */
    private $subRegions;

    /**
     * @JMS\Exclude()
     * @ORM\OneToMany(targetEntity="App\Entity\City", mappedBy="region")
     */
    private $cities;

    /**
     * @JMS\Exclude()
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="region")
     */
    private $people;

    /**
     * @JMS\Exclude()
     * @ORM\OneToMany(targetEntity="App\Entity\Family", mappedBy="region")
     */
    private $families;

    public function __construct() {
        $this->subRegions = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->people = new ArrayCollection();
        $this->families = new ArrayCollection();
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

    /**
     * @return Collection|SubRegion[]
     */
    public function getSubRegions() {
        return $this->subRegions;
    }

    public function addSubRegion(SubRegion $subRegion) {
        if (!$this->subRegions->contains($subRegion)) {
            $this->subRegions[] = $subRegion;
            $subRegion->setRegion($this);
        }

        return $this;
    }

    public function removeSubRegion(SubRegion $subRegion) {
        if ($this->subRegions->contains($subRegion)) {
            $this->subRegions->removeElement($subRegion);
            // set the owning side to null (unless already changed)
            if ($subRegion->getRegion() === $this) {
                $subRegion->setRegion(null);
            }
        }

        return $this;
    }

    public function getCities() {
        return $this->cities;
    }

    public function addCity(City $city) {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
            $city->setRegion($this);
        }

        return $this;
    }

    public function removeCity(City $city) {
        if ($this->cities->contains($city)) {
            $this->cities->removeElement($city);
            // set the owning side to null (unless already changed)
            if ($city->getRegion() === $this) {
                $city->setRegion(null);
            }
        }

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
            $person->setRegion($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getRegion() === $this) {
                $person->setRegion(null);
            }
        }

        return $this;
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
            $family->setRegion($this);
        }

        return $this;
    }

    public function removeFamily(Family $family): self
    {
        if ($this->families->contains($family)) {
            $this->families->removeElement($family);
            // set the owning side to null (unless already changed)
            if ($family->getRegion() === $this) {
                $family->setRegion(null);
            }
        }

        return $this;
    }

}
