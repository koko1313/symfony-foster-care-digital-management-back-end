<?php

namespace App\Entity;

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
}
