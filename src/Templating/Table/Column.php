<?php

namespace Axiom\Templating\Table;

class Column
{
    protected string $name;
    protected string $label;
    protected bool $sortable;
    protected $renderCallback;
    protected string $classes;
    protected string $headerClasses;
    protected string $cellClasses;
    protected string $type;

    public function __construct(string $name, string $label, array $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->sortable = $options['sortable'] ?? false;
        $this->renderCallback = $options['render'] ?? null;
        $this->classes = $options['classes'] ?? '';
        $this->headerClasses = $options['headerClasses'] ?? '';
        $this->cellClasses = $options['cellClasses'] ?? '';
        $this->type = $options['type'] ?? 'text';
    }

    public function renderHeader($theme): string
    {
        $classes = $theme->getHeaderCellClasses() . ' ' . $this->headerClasses;
        if ($this->sortable) {
            $classes .= ' ' . $theme->getSortableHeaderClasses();
        }
        
        $html = '<th class="' . $classes . '"';
        if ($this->sortable) {
            $html .= ' data-sort="' . $this->name . '"';
        }
        $html .= '>';
        $html .= htmlspecialchars($this->label);
        if ($this->sortable) {
            $html .= '<span class="sort-icon ml-1">';
            $html .= '<span x-show="sortColumn === \'' . $this->name . '\' && sortDirection === \'asc\'">';
            $html .= $theme->getAscSortIcon();
            $html .= '</span>';
            $html .= '<span x-show="sortColumn === \'' . $this->name . '\' && sortDirection === \'desc\'">';
            $html .= $theme->getDescSortIcon();
            $html .= '</span>';
            $html .= '</span>';
        }
        $html .= '</th>';
        
        return $html;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function getRenderCallback(): ?callable
    {
        return $this->renderCallback;
    }

    public function getClasses(): string
    {
        return $this->classes;
    }

    public function getHeaderClasses(): string
    {
        return $this->headerClasses;
    }

    public function getCellClasses(): string
    {
        return $this->cellClasses;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'sortable' => $this->sortable,
            'type' => $this->type,
            'classes' => $this->classes,
            'headerClasses' => $this->headerClasses,
            'cellClasses' => $this->cellClasses
        ];
    }
}