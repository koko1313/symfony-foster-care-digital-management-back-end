<?php

namespace App\Entity;

use App\Entity\BaseEntities\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FosterParentRepository")
 */
class FosterParent extends Person
{



}
