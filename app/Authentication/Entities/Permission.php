<?php

namespace App\Authentication\Entities;

use Axiom\Database\Entity as ModelEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Permission Entity
 * 
 * Represents an individual access permission in the system that can be assigned to roles.
 * Maps to the 'permissions' database table.
 * 
 * Relationships:
 * - ManyToOne: Each permission belongs to exactly one Module
 * - ManyToMany: Each permission can be assigned to multiple Roles (inverse side)
 * 
 * Table Structure:
 * - id: INTEGER, primary key, auto-increment
 * - title: VARCHAR(255), human-readable permission name
 * - slug: VARCHAR(255), URL-friendly identifier
 * - module_id: INTEGER, foreign key to modules table
 */
#[Entity]
#[Table(name: 'permissions')]
class Permission extends ModelEntity
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
      Parent::__construct();
    }

    /**
     * Unique identifier for the permission
     * 
     * Database column: id (INTEGER)
     * Primary key, auto-incremented
     * Used as reference in relationship mappings
     */
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    /**
     * Human-readable name of the permission
     * 
     * Database column: title (VARCHAR 255)
     * Example values: 'Create User', 'Edit Content'
     * Displayed in admin interfaces
     */
    #[Column(type: 'string', length: 255)]
    protected string $title;

    /**
     * URL-friendly identifier for the permission
     * 
     * Database column: slug (VARCHAR 255)
     * Example values: 'create-user', 'edit-content'
     * Used in API endpoints and permission checks
     */
    #[Column(type: 'string', length: 255)]
    protected string $slug;

    /**
     * The Module this permission belongs to
     * 
     * Database relationship: ManyToOne
     * Foreign key: module_id references modules.id
     * Cascade operations: persist and remove
     * Owning side of the Module-Permission relationship
     */
    #[ManyToOne(targetEntity: Module::class, inversedBy: 'permissions')]
    #[JoinColumn(name: 'module_id', referencedColumnName: 'id', nullable: false, onDelete:'CASCADE')]
    protected Module $module;

    /**
     * Collection of Roles that have this permission
     * 
     * Database relationship: ManyToMany (inverse side)
     * Mapped by: Role::$permissions property
     * Join table is managed by the Role entity
     * Collection is automatically initialized by Doctrine
     */
    #[ManyToMany(targetEntity: Role::class, mappedBy: 'permissions')]
    protected Collection $roles;
}