<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @JMS\ExclusionPolicy("none")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $secondName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $subRegion;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Position")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     */
    private $position;

    /**
     * @JMS\Exclude()
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     */
    private $roles;

    public function __construct() {
        $this->roles = new ArrayCollection();
    }







    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
        return $this;
    }

    public function getUsername() {
        return (string) $this->email;
    }

    public function getPassword() {
        return (string) $this->password;
    }

    public function setPassword(string $password) {
        $this->password = $password;
        return $this;
    }

    public function getSalt() {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function eraseCredentials() {

    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getSecondName() {
        return $this->secondName;
    }

    public function setSecondName($secondName) {
        $this->secondName = $secondName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function getRegion() {
        return $this->region;
    }

    public function setRegion($region) {
        $this->region = $region;
    }

    public function getSubRegion() {
        return $this->subRegion;
    }

    public function setSubRegion($subRegion) {
        $this->subRegion = $subRegion;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    // overrided to return roles as array of them names
    public function getRoles() {
        $rolesNames = [];

        foreach ($this->roles as $role) {
            array_push($rolesNames, $role->getName());
        }

        return $rolesNames;
    }

    public function addRole(Role $role) {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role) {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }
}
