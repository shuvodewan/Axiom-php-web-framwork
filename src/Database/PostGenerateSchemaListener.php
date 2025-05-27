<?php

namespace Axiom\Database;

use Doctrine\ORM\Tools\Event\GenerateSchemaTableEventArgs;
use Doctrine\ORM\Tools\ToolEvents;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Types\Types;

/**
 * Listener for post schema generation events that ensures timestamp columns
 * (created_at and updated_at) appear at the end of table definitions.
 *
 * This listener addresses the common requirement of having timestamp columns
 * consistently positioned at the end of database tables while maintaining
 * all original column attributes and properties.
 */
class PostGenerateSchemaListener implements EventSubscriber
{
    /**
     * Returns the events this subscriber wants to listen to.
     *
     * @return string[] The list of event names to subscribe to
     */
    public function getSubscribedEvents(): array
    {
        return [
            ToolEvents::postGenerateSchemaTable
        ];
    }

    /**
     * Processes the postGenerateSchemaTable event to reorder timestamp columns.
     *
     * @param GenerateSchemaTableEventArgs $eventArgs The event arguments containing schema information
     */
    public function postGenerateSchemaTable(GenerateSchemaTableEventArgs $eventArgs): void
    {
        $table = $eventArgs->getClassTable();
        $columns = $table->getColumns();
        
        $columnMap = [];
        foreach ($columns as $column) {
            $columnMap[$column->getName()] = $column;
        }
        
        if (!isset($columnMap['created_at'])) {
            return;
        }

        // Store timestamp columns with their full configuration
        $timestampConfigs = [];
        foreach (['created_at', 'updated_at'] as $colName) {
            if (isset($columnMap[$colName])) {
                $column = $columnMap[$colName];
                $timestampConfigs[$colName] = $this->getColumnConfig($column);
                $table->dropColumn($colName);
            }
        }

        // Re-add timestamp columns at the end of the table
        foreach ($timestampConfigs as $name => $config) {
            $table->addColumn($name, $config['type'], $config['options']);
        }
    }

    /**
     * Extracts the complete configuration for a column.
     *
     * @param Column $column The column to extract configuration from
     * @return array An array containing 'type' and 'options' for the column
     */
    protected function getColumnConfig(Column $column): array
    {
        return [
            'type' => $this->getTypeName($column),
            'options' => [
                'notnull' => $column->getNotnull(),
                'default' => $column->getDefault(),
                'comment' => $column->getComment(),
                'columnDefinition' => $column->getColumnDefinition(),
                'length' => $column->getLength(),
                'precision' => $column->getPrecision(),
                'scale' => $column->getScale(),
                'fixed' => $column->getFixed(),
                'unsigned' => $column->getUnsigned(),
                'autoincrement' => $column->getAutoincrement(),
                'platformOptions' => $column->getPlatformOptions(),
            ]
        ];
    }

    /**
     * Gets the standardized type name for a column.
     *
     * This method provides compatibility across different Doctrine DBAL versions
     * by mapping known type classes to their corresponding Types constants.
     *
     * @param Column $column The column to get the type for
     * @return string The standardized type name
     */
    protected function getTypeName(Column $column): string
    {
        $type = $column->getType();

        return match (get_class($type)) {
            \Doctrine\DBAL\Types\StringType::class => Types::STRING,
            \Doctrine\DBAL\Types\IntegerType::class => Types::INTEGER,
            \Doctrine\DBAL\Types\DateTimeType::class => Types::DATETIME_MUTABLE,
            \Doctrine\DBAL\Types\DateTimeImmutableType::class => Types::DATETIME_IMMUTABLE,
            \Doctrine\DBAL\Types\BooleanType::class => Types::BOOLEAN,
            default => get_class($type), // fallback: fully qualified class name
        };
    }

    /**
     * Recreates a column on a table using its configuration.
     *
     * @param mixed $table The table to add the column to
     * @param Column $column The column to recreate
     */
    protected function addColumnFromConfig($table, Column $column): void
    {
        $config = $this->getColumnConfig($column);
        $table->addColumn($column->getName(), $config['type'], $config['options']);
    }
}