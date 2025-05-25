<?php

namespace App\Authentication\Entities;

use Axiom\Database\Entity as ModelEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * User Entity
 * 
 * Maps to the users table in the database.
 */
#[Entity]
#[Table(name: 'users')]
class User extends ModelEntity
{
    /**
     * The unique identifier of the user
     */
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    /**
     * The user's name
     */
    #[Column(type: 'string', length: 255)]
    protected string $name;

    /**
     * The unique username
     */
    #[Column(type: 'string', length: 255, unique: true)]
    protected string $user_name;

    /**
     * The unique email address
     */
    #[Column(type: 'string', length: 255, unique: true)]
    protected string $email;

    /**
     * When the email was verified (nullable)
     */
    #[Column(type: 'datetime', nullable: true)]
    protected ?\DateTime $email_verified_at = null;

    /**
     * The hashed password
     */
    #[Column(type: 'string', length: 255)]
    protected string $password;

    /**
     * Remember token for "remember me" functionality
     */
    #[Column(type: 'string', length: 100, nullable: true)]
    protected ?string $remember_token = null;

    /**
     * The user's profile photo URL
     */
    #[Column(type: 'string', length: 2048, nullable: true)]
    protected ?string $avatar = null;


      /**
     * User and roles many to many relationships
     */
    #[ManyToMany(targetEntity: Role::class, inversedBy: 'users')]
    #[JoinTable(name: 'role_user')]
    #[JoinColumn(name: 'user_id', onDelete: 'CASCADE')]
    #[InverseJoinColumn(name: 'role_id', onDelete: 'CASCADE')]
    protected Collection $roles;

}