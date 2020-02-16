<?php

namespace App\Entity;

use App\Entity\BaseEntities\Person;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FosterParentRepository")
 */
class FosterParent extends Person
{

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="10")
     */
    protected $egn;

    /**
     * @Assert\NotBlank()
     */
    protected $phone;

    /**
     * @Assert\NotBlank()
     */
    protected $education;

    /**
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @Assert\NotBlank()
     */
    protected $gender;

}
