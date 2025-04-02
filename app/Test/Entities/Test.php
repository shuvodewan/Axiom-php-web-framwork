<?php

namespace App\Test\Entities;

use Axiom\Database\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tests')]
class Test extends Entity
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column()]
    protected ?int $id=null;

    protected ?string $title=null;
}