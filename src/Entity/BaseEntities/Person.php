<?php

namespace App\Entity\BaseEntities;

use App\Entity\City;
use App\Entity\Region;
use App\Entity\SubRegion;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint", options={"unsigned" = true})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $egn;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    protected $secondName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region")
     * @Assert\NotBlank()
     */
    protected $region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubRegion")
     * @Assert\NotBlank()
     */
    protected $subRegion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @Assert\NotBlank()
     */
    protected $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $education;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $work;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $employmentType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $citizenship;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEgn(): ?string
    {
        return $this->egn;
    }

    public function setEgn(string $egn): self
    {
        $this->egn = $egn;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function setSecondName(string $secondName): self
    {
        $this->secondName = $secondName;

        return $this;
    }

    public function getLastName(): ?string
{
    return $this->lastName;
}

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getSubRegion(): ?SubRegion
    {
        return $this->subRegion;
    }

    public function setSubRegion(?SubRegion $subRegion): self
    {
        $this->subRegion = $subRegion;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getWork(): ?string
    {
        return $this->work;
    }

    public function setWork(string $work): self
    {
        $this->work = $work;

        return $this;
    }

    public function getEmploymentType(): ?string
    {
        return $this->employmentType;
    }

    public function setEmploymentType(string $employmentType): self
    {
        $this->employmentType = $employmentType;

        return $this;
    }

    public function getCitizenship(): ?string
    {
        return $this->citizenship;
    }

    public function setCitizenship(?string $citizenship): self
    {
        $this->citizenship = $citizenship;

        return $this;
    }
}
