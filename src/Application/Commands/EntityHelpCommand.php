<?php

namespace Axiom\Application\Commands;

use Axiom\Console\Command;

/**
 * EntityHelpCommand Class
 *
 * Displays all available Doctrine ORM attributes for entity mapping.
 */
class EntityHelpCommand extends Command
{
    /**
     * Define validation rules for command arguments.
     *
     * @return array The validation rules
     */
    protected function validator(): array
    {
        return [];
    }

    /**
     * Handle the command execution.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Doctrine ORM Entity Mapping Attributes Reference');
        $this->line(str_repeat('=', 80));
        $this->info('');

        $this->displaySection('CORE ENTITY ATTRIBUTES', [
            ['#[ORM\Entity]', 'Marks class as Doctrine entity'],
            ['#[ORM\Table(name: "table_name")]', 'Specifies database table name'],
            ['#[ORM\Entity(repositoryClass: RepositoryClass::class)]', 'Custom repository class'],
            ['#[ORM\Cache(usage: "READ_ONLY", region: "region_name")]', 'Second-level cache configuration'],
            ['#[ORM\Index(name: "index_name", columns: ["col1", "col2"])]', 'Defines database index'],
            ['#[ORM\UniqueConstraint(name: "constraint_name", columns: ["col1"])]', 'Defines unique constraint'],
        ]);

        $this->displaySection('PRIMARY KEY ATTRIBUTES', [
            ['#[ORM\Id]', 'Marks property as primary key'],
            ['#[ORM\GeneratedValue(strategy: "AUTO")]', 'Generation strategy (AUTO/SEQUENCE/IDENTITY/UUID/CUSTOM)'],
            ['#[ORM\SequenceGenerator(sequenceName: "seq", allocationSize: 1, initialValue: 1)]', 'Sequence generator config'],
            ['#[ORM\Column(type: "integer")]', 'Primary key column definition'],
            ['#[ORM\Version]', 'Optimistic lock version column'],
        ]);

        $this->displaySection('COLUMN ATTRIBUTES', [
            ['#[ORM\Column(type: "string", length: 255)]', 'String column with length'],
            ['#[ORM\Column(type: "integer")]', 'Integer column'],
            ['#[ORM\Column(type: "boolean")]', 'Boolean column'],
            ['#[ORM\Column(type: "float")]', 'Floating point number'],
            ['#[ORM\Column(type: "decimal", precision: 10, scale: 2)]', 'Decimal with precision'],
            ['#[ORM\Column(type: "datetime")]', 'DateTime column'],
            ['#[ORM\Column(type: "date")]', 'Date only column'],
            ['#[ORM\Column(type: "time")]', 'Time only column'],
            ['#[ORM\Column(type: "json")]', 'JSON data column'],
            ['#[ORM\Column(type: "array")]', 'Serialized array column'],
            ['#[ORM\Column(type: "text")]', 'Long text column'],
            ['#[ORM\Column(type: "guid")]', 'UUID/GUID column'],
            ['#[ORM\Column(name: "db_column", nullable: false, unique: true)]', 'Column options'],
            ['#[ORM\Column(options: ["default" => "value", "comment" => "description"])]', 'DBAL-level options'],
            ['#[ORM\Column(enumType: EnumClass::class)]', 'PHP 8.1+ enum type'],
        ]);

        $this->displaySection('RELATIONSHIP ATTRIBUTES', [
            ['#[ORM\ManyToOne(targetEntity: Entity::class)]', 'Many-to-one relationship'],
            ['#[ORM\OneToMany(mappedBy: "field", targetEntity: Entity::class)]', 'One-to-many relationship'],
            ['#[ORM\OneToOne(targetEntity: Entity::class)]', 'One-to-one relationship'],
            ['#[ORM\ManyToMany(targetEntity: Entity::class)]', 'Many-to-many relationship'],
            ['#[ORM\JoinColumn(name: "fk", referencedColumnName: "id", nullable: false)]', 'Join column config'],
            ['#[ORM\JoinTable(name: "join_table")]', 'Join table for many-to-many'],
            ['#[ORM\OrderBy({"field" = "ASC", "another" = "DESC"})]', 'Default ordering'],
            ['#[ORM\InverseJoinColumn(name: "group_id", referencedColumnName: "id")]', 'Inverse side of join table'],
        ]);

        $this->displaySection('INHERITANCE MAPPING', [
            ['#[ORM\InheritanceType("SINGLE_TABLE")]', 'Single table inheritance'],
            ['#[ORM\DiscriminatorColumn(name: "type", type: "string")]', 'Discriminator column'],
            ['#[ORM\DiscriminatorMap(["type1" => Class1::class, "type2" => Class2::class])]', 'Entity type mapping'],
            ['#[ORM\MappedSuperclass]', 'Non-entity parent class'],
        ]);

        $this->displaySection('EMBEDDABLES (VALUE OBJECTS)', [
            ['#[ORM\Embeddable]', 'Marks class as embeddable'],
            ['#[ORM\Embedded(class: Embeddable::class)]', 'Embeds value object'],
        ]);

        $this->displaySection('LIFECYCLE CALLBACKS', [
            ['#[ORM\PrePersist]', 'Before entity is first persisted'],
            ['#[ORM\PostPersist]', 'After entity is persisted'],
            ['#[ORM\PreUpdate]', 'Before entity is updated'],
            ['#[ORM\PostUpdate]', 'After entity is updated'],
            ['#[ORM\PreRemove]', 'Before entity is removed'],
            ['#[ORM\PostRemove]', 'After entity is removed'],
            ['#[ORM\PostLoad]', 'After entity is loaded'],
        ]);

        $this->displaySection('CUSTOM TYPES', [
            ['#[ORM\CustomIdGenerator(class: CustomGenerator::class)]', 'Custom ID generator'],
            ['#[ORM\Column(type: "custom_type")]', 'Custom DBAL type'],
        ]);

        $this->info('');
        $this->info('Note: All attributes are in the Doctrine\ORM\Mapping namespace (use Doctrine\ORM\Mapping as ORM;)');
        $this->info('For detailed usage, refer to Doctrine ORM documentation.');
        $this->line(str_repeat('=', 80));
    }

    /**
     * Display a section with formatted table.
     *
     * @param string $title
     * @param array $items
     */
    protected function displaySection(string $title, array $items): void
    {

        $this->comment(strtoupper($title));
        $this->table($items);
        $this->info('');
    }
}