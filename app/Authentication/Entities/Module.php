<?php

namespace App\Authentication\Entities;

use Axiom\Database\Entity as ModelEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Module Entity
 * 
 * Represents a functional component or section of the application.
 * Serves as a grouping mechanism for related permissions.
 * 
 * Database Table: modules
 * Relationships:
 *   - OneToMany: Each module can have multiple Permissions
 */
#[Entity]
#[Table(name: 'modules')]
class Module extends ModelEntity
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
     * The unique identifier of the module
     * 
     * Database Column: id (INTEGER)
     * Features:
     *   - Primary key
     *   - Auto-incremented
     *   - Unique across all modules
     */
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    /**
     * The title of the module
     * 
     * Database Column: title (VARCHAR 255)
     * Usage:
     *   - Human-readable module name
     *   - Displayed in admin interfaces
     * Example: "User Management", "Content Management"
     */
    #[Column(type: 'string', length: 255)]
    protected string $title;

    /**
     * The URL-friendly slug of the module
     * 
     * Database Column: slug (VARCHAR 255)
     * Usage:
     *   - Machine-readable identifier
     *   - Used in API endpoints
     *   - Employed for system references
     * Example: "user-management", "content-management"
     */
    #[Column(type: 'string', length: 255)]
    protected string $slug;

    /**
     * The permissions belonging to this module
     * 
     * Database Relationship: OneToMany
     * Mapped By: Permission::$module
     * Behavior:
     *   - Inverse side of relationship
     *   - Changes tracked by Doctrine
     *   - Collection automatically initialized
     */
    #[OneToMany(targetEntity: Permission::class, mappedBy: 'module', cascade: ['persist'])]
    protected Collection $permissions;
}