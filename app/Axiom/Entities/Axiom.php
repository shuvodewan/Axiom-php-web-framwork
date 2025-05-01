<?php

namespace App\Axiom\Entities;

use Axiom\Database\Entity as ModelEntity;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;


/**
 * Axiom Entity
 * 
 * Maps to the axioms table in the database.
 */
#[Entity]
#[Table(name: 'axioms')]
class Axiom extends ModelEntity
{
    
}