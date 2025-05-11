<?php

namespace App\Authentication\Entities;

use Axiom\Database\Entity as ModelEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Role Entity
 * 
 * Maps to the roles table in the database.
 */
#[Entity]
#[Table(name: 'roles')]
class Role extends ModelEntity
{
     /**
     * The unique identifier of the module
     */
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    /**
     * The title of the module
     */
    #[Column(type: 'string', length: 255)]
    protected string $title;

    /**
     * The URL-friendly slug of the module
     */
    #[Column(type: 'string', length: 255)]
    protected string $slug;

    /**
     * Deleteable false to prevent delete sensative role
     */
    #[Column(type: 'boolean', length: 255)]
    protected bool $deleteable = true;

     /**
     * Role and permissions many to many relationships
     */
    #[ManyToMany(targetEntity:Permission::class, inversedBy:'roles', cascade: ['persist', 'remove'])]
    #[JoinTable(name:'permission_role')]
    protected Collection $permissions;
}