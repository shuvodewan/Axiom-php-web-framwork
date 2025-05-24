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
use Doctrine\ORM\Mapping\OneToMany;

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
    #[ManyToMany(targetEntity: Permission::class, inversedBy: 'roles')]
    #[JoinTable(name: 'permission_role')]
    #[JoinColumn(name: 'role_id', onDelete: 'CASCADE')]
    #[InverseJoinColumn(name: 'permission_id', onDelete: 'CASCADE')]
    protected Collection $permissions;


    #[OneToMany(targetEntity:User::class, mappedBy:'role')]
    protected Collection $users;



    //scopes

    public function scopeSearch($query, $value){
        $query->where('title','LIKE','%'. $value .'%');
    }
}