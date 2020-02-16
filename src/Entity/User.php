<?php

namespace App\Entity;

use App\Entity\BaseEntities\Person;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorMap({
 *     "administrator" = "Administrator",
 *     "employeeOEPG" = "EmployeeOEPG"
 * })
 */
abstract class User extends Person implements UserInterface
{

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @JMS\Exclude()
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     */
    protected $roles;

    public function __construct() {
        $this->roles = new ArrayCollection();
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
