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
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="10")
     */
    protected $egn;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\NotBlank()
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    protected $education;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Choice({"woman", "man"})
     */
    protected $gender;

}
