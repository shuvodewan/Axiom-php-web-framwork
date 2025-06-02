<?php

namespace Axiom\Templating\Table;

use Axiom\Templating\List\Themes\TailwindTheme;

class TableBuilder
{
    protected array $columns = [];
    protected array $filters = [];
    protected string $ajaxUrl = '';
    protected int $perPage = 15;
    protected $theme;
    protected array $tableAttributes = [];
    protected array $rowCallbacks = [];
    protected bool $loading = false;

    public function __construct($theme = null)
    {
        $this->setTheme($theme ?? new TailwindTheme());
    }

    public function setTheme($theme): self
    {
        $this->theme = $theme;
        return $this;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function addColumn(string $name, string $label, array $options = []): self
    {
        $this->columns[$name] = [
            'label' => $label,
            'sortable' => $options['sortable'] ?? false,
            'render' => $options['render'] ?? null,
            'classes' => $options['classes'] ?? null,
        ];
        return $this;
    }

    public function addFilter(string $name, string $label, string $type = 'text', array $options = []): self
    {
        $this->filters[$name] = [
            'label' => $label,
            'type' => $type,
            'options' => $options['options'] ?? [],
            'placeholder' => $options['placeholder'] ?? null,
        ];
        return $this;
    }

    public function setAjaxUrl(string $url): self
    {
        $this->ajaxUrl = $url;
        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function setTableAttribute(string $name, string $value): self
    {
        $this->tableAttributes[$name] = $value;
        return $this;
    }

    public function onRow(callable $callback): self
    {
        $this->rowCallbacks[] = $callback;
        return $this;
    }

    public function render(): string
    {
        $tableClasses = $this->tableAttributes['class'] ?? $this->theme->getTableClasses();
        
        $tableAttributes = array_merge([
            'class' => $tableClasses,
        ], array_filter($this->tableAttributes, fn($key) => $key !== 'class', ARRAY_FILTER_USE_KEY));

        $html = '<div class="axiom-table-container">';
        
        // Render filters if any
        if (!empty($this->filters)) {
            $html .= $this->renderFilters();
        }
        
        // Table structure
        $html .= '<table ' . $this->buildAttributes($tableAttributes) . '>';
        $html .= $this->renderHeader();
        $html .= $this->renderBody();
        $html .= '</table>';
        
        // Pagination
        $html .= $this->renderPagination();
        
        $html .= '</div>';
        
        // JavaScript initialization
        $html .= $this->renderScript();
        
        return $html;
    }

    protected function renderHeader(): string
    {
        $headerClasses = $this->theme->getHeaderClasses();
        $html = '<thead class="' . $headerClasses . '">';
        $html .= '<tr>';

        foreach ($this->columns as $name => $column) {
            $cellClasses = $this->theme->getHeaderCellClasses();
            if ($column['sortable']) {
                $cellClasses .= ' ' . $this->theme->getSortableHeaderClasses();
            }
            if (isset($column['classes'])) {
                $cellClasses .= ' ' . $column['classes'];
            }

            $html .= '<th class="' . $cellClasses . '"';
            if ($column['sortable']) {
                $html .= ' data-sort="' . $name . '"';
            }
            $html .= '>' . htmlspecialchars($column['label']) . '</th>';
        }

        $html .= '</tr>';
        $html .= '</thead>';
        return $html;
    }

    protected function renderBody(): string
    {
        if ($this->loading) {
            return '<tbody><tr><td colspan="' . count($this->columns) . '">' . $this->theme->getLoadingIndicator() . '</td></tr></tbody>';
        }

        // In a real implementation, this would be populated via AJAX
        return '<tbody><tr><td colspan="' . count($this->columns) . '">' . $this->theme->getEmptyState() . '</td></tr></tbody>';
    }

    protected function renderFilters(): string
    {
        $html = '<div class="table-filters mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">';
        
        foreach ($this->filters as $name => $filter) {
            $html .= '<div class="filter-group">';
            $html .= '<label class="' . $this->theme->getLabelClasses() . '">' . htmlspecialchars($filter['label']) . '</label>';
            
            $filterClasses = $this->theme->getFilterClasses();
            
            switch ($filter['type']) {
                case 'select':
                    $html .= '<select class="' . $filterClasses . '" data-filter="' . $name . '">';
                    if ($filter['placeholder']) {
                        $html .= '<option value="">' . htmlspecialchars($filter['placeholder']) . '</option>';
                    }
                    foreach ($filter['options'] as $value => $label) {
                        $html .= '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($label) . '</option>';
                    }
                    $html .= '</select>';
                    break;
                case 'date':
                    $html .= '<input type="date" class="' . $filterClasses . '" data-filter="' . $name . '">';
                    break;
                default:
                    $html .= '<input type="text" class="' . $filterClasses . '" data-filter="' . $name . '" placeholder="' . htmlspecialchars($filter['placeholder'] ?? '') . '">';
            }
            
            $html .= '</div>';
        }
        
        $html .= '</div>';
        return $html;
    }

    protected function renderPagination(): string
    {
        $classes = $this->theme->getPaginationClasses();
        return '<div class="' . $classes . '">
            <div class="flex-1 flex justify-between sm:hidden">
                <button class="btn-prev">Previous</button>
                <button class="btn-next">Next</button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div class="pagination-info"></div>
                <div class="pagination-links"></div>
            </div>
        </div>';
    }

    protected function renderScript(): string
    {
        return '<script>
            document.addEventListener("DOMContentLoaded", function() {
                new AxiomTable('.json_encode([
                    'ajaxUrl' => $this->ajaxUrl,
                    'perPage' => $this->perPage,
                    'columns' => $this->columns,
                    'filters' => $this->filters,
                ]).');
            });
        </script>';
    }

    protected function buildAttributes(array $attributes): string
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            $html[] = sprintf('%s="%s"', htmlspecialchars($key), htmlspecialchars($value));
        }
        return implode(' ', $html);
    }
}