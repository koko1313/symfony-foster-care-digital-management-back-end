<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilyRepository")
 */
class Family {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titular;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $womanFirstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $womanSecondName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $womanLastName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $manFirstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $manSecondName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $manLastName;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $preferKidGender;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $preferKidMinAge;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $preferKidMaxAge;

    public function getId() {
        return $this->id;
    }

    public function getTitular() {
        return $this->titular;
    }

    public function setTitular(string $titular) {
        $this->titular = $titular;
        return $this;
    }

    public function getWomanFirstName() {
        return $this->womanFirstName;
    }

    public function setWomanFirstName(string $womanFirstName) {
        $this->womanFirstName = $womanFirstName;
        return $this;
    }

    public function getWomanSecondName() {
        return $this->womanSecondName;
    }

    public function setWomanSecondName(string $womanSecondName) {
        $this->womanSecondName = $womanSecondName;
        return $this;
    }

    public function getWomanLastName() {
        return $this->womanLastName;
    }

    public function setWomanLastName(string $womanLastName) {
        $this->womanLastName = $womanLastName;
        return $this;
    }

    public function getManFirstName() {
        return $this->manFirstName;
    }

    public function setManFirstName(string $manFirstName) {
        $this->manFirstName = $manFirstName;
        return $this;
    }

    public function getManSecondName() {
        return $this->manSecondName;
    }

    public function setManSecondName(string $manSecondName) {
        $this->manSecondName = $manSecondName;
        return $this;
    }

    public function getManLastName() {
        return $this->manLastName;
    }

    public function setManLastName(string $manLastName) {
        $this->manLastName = $manLastName;
        return $this;
    }

    public function getPreferKidGender() {
        return $this->preferKidGender;
    }

    public function setPreferKidGender(?string $preferKidGender) {
        $this->preferKidGender = $preferKidGender;
        return $this;
    }

    public function getPreferKidMinAge() {
        return $this->preferKidMinAge;
    }

    public function setPreferKidMinAge(?int $preferKidMinAge) {
        $this->preferKidMinAge = $preferKidMinAge;
        return $this;
    }

    public function getPreferKidMaxAge() {
        return $this->preferKidMaxAge;
    }

    public function setPreferKidMaxAge(?int $preferKidMaxAge) {
        $this->preferKidMaxAge = $preferKidMaxAge;
        return $this;
    }
}
