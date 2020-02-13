<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilyRepository")
 * @JMS\ExclusionPolicy("none")
 */
class Family {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titular;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FosterParent", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $woman;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FosterParent", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $man;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EmployeeOEPG", inversedBy="families")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $warden;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="families")
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubRegion", inversedBy="families")
     */
    private $subRegion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="families")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $levelOfBulgarianLanguage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $religion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $familyType; // professional, volunteer

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $averageMonthlyIncomePerFamilyMember;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $houseType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $employmentType;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $anotherIncome;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FamilyMember", mappedBy="family")
     * @JMS\Exclude()
     */
    private $familyMembers;

    public function __construct()
    {
        $this->familyMembers = new ArrayCollection();
    }

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

    public function getWoman(): ?FosterParent
    {
        return $this->woman;
    }

    public function setWoman(?FosterParent $woman): self
    {
        $this->woman = $woman;

        return $this;
    }

    public function getMan(): ?FosterParent
    {
        return $this->man;
    }

    public function setMan(?FosterParent $man): self
    {
        $this->man = $man;

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

    public function getWarden(): ?EmployeeOEPG
    {
        return $this->warden;
    }

    public function setWarden(?EmployeeOEPG $warden): self
    {
        $this->warden = $warden;

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

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getLevelOfBulgarianLanguage(): ?string
    {
        return $this->levelOfBulgarianLanguage;
    }

    public function setLevelOfBulgarianLanguage(?string $levelOfBulgarianLanguage): self
    {
        $this->levelOfBulgarianLanguage = $levelOfBulgarianLanguage;

        return $this;
    }

    public function getReligion(): ?string
    {
        return $this->religion;
    }

    public function setReligion(?string $religion): self
    {
        $this->religion = $religion;

        return $this;
    }

    public function getFamilyType(): ?string
    {
        return $this->familyType;
    }

    public function setFamilyType(?string $familyType): self
    {
        $this->familyType = $familyType;

        return $this;
    }

    public function getAverageMonthlyIncomePerFamilyMember(): ?float
    {
        return $this->averageMonthlyIncomePerFamilyMember;
    }

    public function setAverageMonthlyIncomePerFamilyMember(?float $averageMonthlyIncomePerFamilyMember): self
    {
        $this->averageMonthlyIncomePerFamilyMember = $averageMonthlyIncomePerFamilyMember;

        return $this;
    }

    public function getHouseType(): ?string
    {
        return $this->houseType;
    }

    public function setHouseType(?string $houseType): self
    {
        $this->houseType = $houseType;

        return $this;
    }

    public function getEmploymentType(): ?string
    {
        return $this->employmentType;
    }

    public function setEmploymentType(?string $employmentType): self
    {
        $this->employmentType = $employmentType;

        return $this;
    }

    public function getAnotherIncome(): ?float
    {
        return $this->anotherIncome;
    }

    public function setAnotherIncome(?float $anotherIncome): self
    {
        $this->anotherIncome = $anotherIncome;

        return $this;
    }

    /**
     * @return Collection|FamilyMember[]
     */
    public function getFamilyMembers(): Collection
    {
        return $this->familyMembers;
    }

    public function addFamilyMember(FamilyMember $familyMember): self
    {
        if (!$this->familyMembers->contains($familyMember)) {
            $this->familyMembers[] = $familyMember;
            $familyMember->setFamily($this);
        }

        return $this;
    }

    public function removeFamilyMember(FamilyMember $familyMember): self
    {
        if ($this->familyMembers->contains($familyMember)) {
            $this->familyMembers->removeElement($familyMember);
            // set the owning side to null (unless already changed)
            if ($familyMember->getFamily() === $this) {
                $familyMember->setFamily(null);
            }
        }

        return $this;
    }
}
