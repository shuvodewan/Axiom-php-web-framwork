<?php

namespace Axiom\Templating\Table;

use Axiom\Http\Transformer;
use Axiom\Templating\Table\Themes\TailwindTheme;

class TableBuilder
{
    protected string $id;
    protected array $columns = [];
    protected array $filters = [];
    protected array $actions = [];
    protected array $bulkActions = [];
    protected $data;
    protected int $perPage = 15;
    protected $theme;
    protected array $tableAttributes = [];
    protected array $rowCallbacks = [];
    protected bool $serverSide = true;
    protected array $defaultSort = [];
    protected array $exports = [];
    protected array $config = [];
    protected string $jsFilePath;
    protected bool $withBulkActions = false;
    protected bool $withRowSelection = false;
    protected array $rowAttributes = [];
    protected array $headerAttributes = [];
    protected array $footerAttributes = [];
    protected ?string $noResultsText = null;
    protected ?string $loadingText = null;
    protected array $sortableColumns = [];

    public function __construct(?string $id = null, $theme = null)
    {
        $this->id = $id ?? 'table-' . uniqid();
        $this->setTheme($theme ?? new TailwindTheme());
        $this->config = [
            'i18n' => [
                'loading' => 'Loading...',
                'noResults' => 'No records found',
                'showing' => 'Showing',
                'to' => 'to',
                'of' => 'of',
                'results' => 'results',
                'filter' => 'Filter',
                'reset' => 'Reset',
                'bulkActions' => 'Bulk Actions',
                'apply' => 'Apply',
                'selectAll' => 'Select All',
                'selected' => 'selected',
                'actions' => 'Actions',
                'previous' => 'Previous', // Add this
                'next' => 'Next' // Add this
            ]
        ];
        $this->jsFilePath = __dir__.'/Themes/axiomTable.js';
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setTheme($theme): self
    {
        $this->theme = $theme;
        return $this;
    }

    public function setData($data): self
    {
        if ($data instanceof Transformer) {
            $this->data = $data->value();
        } else {
            $this->data = $data;
        }
        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function setServerSide(bool $serverSide): self
    {
        $this->serverSide = $serverSide;
        return $this;
    }

    public function setDefaultSort(string $column, string $direction = 'asc'): self
    {
        $this->defaultSort = [$column, $direction];
        return $this;
    }

    public function setJsFilePath(string $path): self
    {
        $this->jsFilePath = $path;
        return $this;
    }

    public function setNoResultsText(string $text): self
    {
        $this->noResultsText = $text;
        return $this;
    }

    public function setLoadingText(string $text): self
    {
        $this->loadingText = $text;
        return $this;
    }

    public function setTableAttribute(string $name, string $value): self
    {
        $this->tableAttributes[$name] = $value;
        return $this;
    }

    public function setRowAttribute(string $name, string $value): self
    {
        $this->rowAttributes[$name] = $value;
        return $this;
    }

    public function setHeaderAttribute(string $name, string $value): self
    {
        $this->headerAttributes[$name] = $value;
        return $this;
    }

    public function setFooterAttribute(string $name, string $value): self
    {
        $this->footerAttributes[$name] = $value;
        return $this;
    }

    public function withBulkActions(bool $enabled = true): self
    {
        $this->withBulkActions = $enabled;
        return $this;
    }

    public function withRowSelection(bool $enabled = true): self
    {
        $this->withRowSelection = $enabled;
        return $this;
    }

    public function addColumn(string $name, string $label, array $options = []): self
    {
        $this->columns[$name] = new Column($name, $label, $options);
        
        if ($options['sortable'] ?? false) {
            $this->sortableColumns[] = $name;
        }
        
        return $this;
    }

    public function addFilter(string $name, string $type = 'text', array $options = []): self
    {
        $filterTypes = [
            'text' => Filters\TextFilter::class,
            'select' => Filters\SelectFilter::class,
            'date' => Filters\DateFilter::class,
            'date_range' => Filters\DateRangeFilter::class,
            'number' => Filters\NumberFilter::class,
            'boolean' => Filters\BooleanFilter::class,
        ];

        $filterClass = $filterTypes[$type] ?? Filters\TextFilter::class;
        $this->filters[$name] = new $filterClass($name, $options);
        return $this;
    }

    public function addAction(string $name, string $label, array $options = []): self
    {
        $this->actions[$name] = new Action($name, $label, $options);
        return $this;
    }

    public function addBulkAction(string $name, string $label, array $options = []): self
    {
        $this->bulkActions[$name] = new BulkAction($name, $label, $options);
        $this->withBulkActions = true;
        return $this;
    }

    public function addExport(string $type, string $label, array $options = []): self
    {
        $this->exports[$type] = new Export($type, $label, $options);
        return $this;
    }

    public function onRow(callable $callback): self
    {
        $this->rowCallbacks[] = $callback;
        return $this;
    }

    public function render(): string
    {
        $html = '<div id="' . $this->id . '-container" x-data="tableComponent()" x-init="initTable()">';
        $html .= $this->renderToolbar();
        $html .= $this->renderFilters();
        $html .= $this->renderTable();
        $html .= $this->renderPagination();
        $html .= $this->renderScript();
        $html .= '</div>';

        return $html;
    }

    protected function renderToolbar(): string
    {
        $html = '<div class="flex flex-wrap justify-between items-center mb-4 gap-4">';
        
        // Bulk actions
        if (!empty($this->bulkActions)) {
            $html .= '<div class="' . $this->theme->getBulkActionClasses() . '">';
            $html .= '<select x-model="bulkAction" class="' . $this->theme->getSelectClasses() . '">';
            $html .= '<option value="">' . $this->config['i18n']['bulkActions'] . '</option>';
            foreach ($this->bulkActions as $action) {
                $html .= '<option value="' . $action->getName() . '">' . $action->getLabel() . '</option>';
            }
            $html .= '</select>';
            $html .= '<button @click="executeBulkAction" class="' . $this->theme->getButtonClasses() . ' ml-2">';
            $html .= $this->config['i18n']['apply'] . '</button>';
            $html .= '</div>';
        }
        
        // Exports
        if (!empty($this->exports)) {
            $html .= '<div class="flex gap-2">';
            foreach ($this->exports as $export) {
                $html .= '<button @click="export(\'' . $export->getType() . '\')" class="' . $this->theme->getButtonSecondaryClasses() . '">';
                $html .= $export->getLabel() . '</button>';
            }
            $html .= '</div>';
        }
        
        $html .= '</div>';
        return $html;
    }

    protected function renderFilters(): string
    {
        if (empty($this->filters)) return '';

        $html = '<div class="' . $this->theme->getFilterWrapperClasses() . ' mb-6">';
        
        foreach ($this->filters as $filter) {
            $html .= '<div class="' . $this->theme->getFilterGroupClasses() . '">';
            $html .= '<label class="' . $this->theme->getFilterLabelClasses() . '">';
            $html .= htmlspecialchars($filter->getLabel());
            $html .= '</label>';
            $html .= $filter->render($this->theme);
            $html .= '</div>';
        }
        
        $html .= '<div class="col-12 mt-2">';
        $html .= '<div class="flex gap-2">';
        $html .= '<button @click="applyFilters" class="' . $this->theme->getButtonClasses() . '">';
        $html .= $this->config['i18n']['filter'] . '</button>';
        $html .= '<button @click="resetFilters" class="' . $this->theme->getButtonSecondaryClasses() . '">';
        $html .= $this->config['i18n']['reset'] . '</button>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div>';
        return $html;
    }

    protected function renderTable(): string
    {
        $tableClasses = $this->theme->getTableClasses();
        $wrapperClasses = $this->theme->getTableWrapperClasses();
        
        $html = '<div class="' . $wrapperClasses . '">';
        $html .= '<table id="' . $this->id . '" class="' . $tableClasses . '" x-ref="table" ' . $this->buildAttributes($this->tableAttributes) . '>';
        $html .= $this->renderHeader();
        $html .= $this->renderBody();
        $html .= $this->renderFooter();
        $html .= '</table>';
        $html .= '</div>';
        
        return $html;
    }

    protected function renderHeader(): string
    {
        $headerClasses = $this->theme->getHeaderClasses();
        $html = '<thead class="' . $headerClasses . '" ' . $this->buildAttributes($this->headerAttributes) . '>';
        $html .= '<tr>';
        
        // Bulk select checkbox
        if ($this->withBulkActions || $this->withRowSelection) {
            $html .= '<th class="' . $this->theme->getHeaderCellClasses() . ' w-10">';
            $html .= '<input type="checkbox" @click="toggleAllRows" x-model="selectAll">';
            $html .= '</th>';
        }
        
        foreach ($this->columns as $column) {
            $html .= $column->renderHeader($this->theme);
        }
        
        // Actions column
        if (!empty($this->actions)) {
            $html .= '<th class="' . $this->theme->getHeaderCellClasses() . ' text-right">';
            $html .= $this->config['i18n']['actions'] . '</th>';
        }
        
        $html .= '</tr>';
        $html .= '</thead>';
        return $html;
    }

    protected function renderBody(): string
    {
        $html = '<tbody>';
        
        if ($this->serverSide) {
            // Server-side rendering - will be populated via AJAX
            $html .= '<tr x-show="loading">';
            $html .= '<td colspan="' . $this->getColspan() . '">';
            $html .= $this->getLoadingIndicator();
            $html .= '</td>';
            $html .= '</tr>';
            
            $html .= '<template x-for="(row, index) in rows" :key="index">';
            $html .= '<tr :class="theme.getRowClasses()" ' . $this->buildAttributes($this->rowAttributes) . '>';
            $this->renderRowTemplate($html);
            $html .= '</tr>';
            $html .= '</template>';
            
            $html .= '<tr x-show="!loading && rows.length === 0">';
            $html .= '<td colspan="' . $this->getColspan() . '">';
            $html .= $this->getEmptyState();
            $html .= '</td>';
            $html .= '</tr>';
        } else {
            // Client-side rendering
            if (is_array($this->data)) {
                $paginatedData = $this->prepareClientSideData();
                
                if (count($paginatedData['data']) > 0) {
                    foreach ($paginatedData['data'] as $row) {
                        $html .= $this->renderRow($row);
                    }
                } else {
                    $html .= '<tr>';
                    $html .= '<td colspan="' . $this->getColspan() . '">';
                    $html .= $this->getEmptyState();
                    $html .= '</td>';
                    $html .= '</tr>';
                }
            }
        }
        
        $html .= '</tbody>';
        return $html;
    }

    protected function renderRow(array $row): string
    {
        $html = '<tr class="' . $this->theme->getRowClasses() . '" ' . $this->buildAttributes($this->rowAttributes) . '>';
        
        // Bulk select checkbox
        if ($this->withBulkActions || $this->withRowSelection) {
            $html .= '<td class="' . $this->theme->getCellClasses() . '">';
            $html .= '<input type="checkbox" data-row-id="' . ($row['id'] ?? '') . '">';
            $html .= '</td>';
        }
        
        // Data columns
        foreach ($this->columns as $column) {
            $html .= $this->renderCell($column, $row);
        }
        
        // Actions
        if (!empty($this->actions)) {
            $html .= '<td class="' . $this->theme->getCellClasses() . ' text-right">';
            $html .= '<div class="flex justify-end gap-2">';
            foreach ($this->actions as $action) {
                $html .= $action->render($this->theme, $row);
            }
            $html .= '</div>';
            $html .= '</td>';
        }
        
        $html .= '</tr>';
        return $html;
    }

    protected function renderCell(Column $column, array $row): string
    {
        $value = $this->getNestedValue($row, $column->getName());
        
        $html = '<td class="' . $this->theme->getCellClasses() . ' ' . $column->getCellClasses() . '">';
        
        if ($column->getRenderCallback()) {
            $html .= call_user_func($column->getRenderCallback(), $value, $row);
        } else {
            $html .= htmlspecialchars($value ?? '');
        }
        
        $html .= '</td>';
        return $html;
    }

    protected function renderRowTemplate(string &$html): void
    {
        // Bulk select checkbox
        if ($this->withBulkActions || $this->withRowSelection) {
            $html .= '<td class="' . $this->theme->getCellClasses() . '">';
            $html .= '<input type="checkbox" x-model="selectedRows[index]">';
            $html .= '</td>';
        }
        
        // Data columns
        foreach ($this->columns as $column) {
            $html .= '<td class="' . $this->theme->getCellClasses() . ' ' . $column->getCellClasses() . '">';
            
            if ($column->getRenderCallback()) {
                $html .= '<span x-text="renderColumn(row, \'' . $column->getName() . '\')"></span>';
            } else {
                $html .= '<span x-text="getNestedValue(row, \'' . $column->getName() . '\')"></span>';
            }
            
            $html .= '</td>';
        }
        
        // Actions
        if (!empty($this->actions)) {
            $html .= '<td class="' . $this->theme->getCellClasses() . ' text-right">';
            $html .= '<div class="flex justify-end gap-2">';
            
            foreach ($this->actions as $action) {
                $html .= $action->renderTemplate($this->theme);
            }
            
            $html .= '</div>';
            $html .= '</td>';
        }
    }

    protected function renderFooter(): string
    {
        if (empty($this->footerAttributes)) {
            return '';
        }

        $html = '<tfoot ' . $this->buildAttributes($this->footerAttributes) . '>';
        $html .= '<tr>';
        $html .= '<td colspan="' . $this->getColspan() . '">';
        $html .= '<!-- Footer content can be added here -->';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</tfoot>';
        
        return $html;
    }

    protected function renderPagination(): string
    {
        $classes = $this->theme->getPaginationClasses();
        
        $html = '<div class="' . $classes . '" x-show="total > 0">';
        $html .= '<div class="flex flex-col sm:flex-row justify-between items-center gap-4">';
        $html .= '<div class="pagination-info text-sm text-gray-600" x-text="paginationInfo"></div>';
        $html .= '<div class="pagination-links flex gap-1">';
        $html .= '<button @click="previousPage" :disabled="currentPage === 1" class="' . $this->theme->getPaginationButtonClasses() . '">';
        $html .= $this->config['i18n']['previous'] . '</button>';
        
        $html .= '<template x-for="page in visiblePages" :key="page">';
        $html .= '<button @click="goToPage(page)" :class="{ \'' . $this->theme->getActivePaginationButtonClasses() . '\': currentPage === page }" class="' . $this->theme->getPaginationButtonClasses() . '">';
        $html .= '<span x-text="page"></span>';
        $html .= '</button>';
        $html .= '</template>';
        
        $html .= '<button @click="nextPage" :disabled="currentPage === totalPages" class="' . $this->theme->getPaginationButtonClasses() . '">';
        $html .= $this->config['i18n']['next'] . '</button>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }

    protected function renderScript(): string
    {
        $html = '<script src="' . $this->jsFilePath . '"></script>';
        $html .= '<script>';
        $html .= 'document.addEventListener(\'DOMContentLoaded\', function() {';
        $html .= 'if (typeof AxiomTable !== \'undefined\') {';
        $html .= 'new AxiomTable(' . json_encode($this->getClientConfig()) . ');';
        $html .= '}';
        $html .= '});';
        $html .= '</script>';

        return $html;
    }
    protected function getClientConfig(): array
    {
        $config = [
            'id' => $this->id,
            'serverSide' => $this->serverSide,
            'ajaxUrl' => $this->config['ajaxUrl'] ?? '',
            'perPage' => $this->perPage,
            'columns' => array_map(fn($col) => $col->toArray(), $this->columns),
            'filters' => array_map(fn($filter) => $filter->toArray(), $this->filters),
            'actions' => array_map(fn($action) => $action->toArray(), $this->actions),
            'bulkActions' => array_map(fn($action) => $action->toArray(), $this->bulkActions),
            'exports' => array_map(fn($export) => $export->toArray(), $this->exports),
            'defaultSort' => $this->defaultSort,
            'i18n' => $this->config['i18n'],
            'theme' => $this->theme->toArray(), // This will now work
            'withBulkActions' => $this->withBulkActions,
            'withRowSelection' => $this->withRowSelection,
            'sortableColumns' => $this->sortableColumns
        ];
    
        if (!$this->serverSide && is_array($this->data)) {
            $config['data'] = $this->prepareClientSideData();
        }
    
        return $config;
    }

    protected function prepareClientSideData(): array
    {
        if (isset($this->data['items'])) {
            // Paginated data format
            return [
                'data' => $this->data['items'],
                'total' => $this->data['meta']['total'] ?? count($this->data['items']),
                'per_page' => $this->data['meta']['per_page'] ?? $this->perPage,
                'current_page' => $this->data['meta']['current_page'] ?? 1,
                'last_page' => $this->data['meta']['last_page'] ?? 1
            ];
        }

        // Regular array format
        return [
            'data' => $this->data,
            'total' => count($this->data),
            'per_page' => $this->perPage,
            'current_page' => 1,
            'last_page' => ceil(count($this->data) / $this->perPage)
        ];
    }

    protected function getLoadingIndicator(): string
    {
        if ($this->loadingText) {
            return '<div class="text-center py-8 text-gray-500">' . $this->loadingText . '</div>';
        }
        return $this->theme->getLoadingIndicator();
    }

    protected function getEmptyState(): string
    {
        if ($this->noResultsText) {
            return '<div class="text-center py-8 text-gray-500">' . $this->noResultsText . '</div>';
        }
        return $this->theme->getEmptyState();
    }

    protected function getColspan(): int
    {
        return count($this->columns) + 
               ($this->withBulkActions || $this->withRowSelection ? 1 : 0) + 
               (!empty($this->actions) ? 1 : 0);
    }

    protected function getNestedValue(array $array, string $key)
    {
        $keys = explode('.', $key);
        $value = $array;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return null;
            }
            $value = $value[$k];
        }

        return $value;
    }

    protected function buildAttributes(array $attributes): string
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            $html[] = $key . '="' . htmlspecialchars($value) . '"';
        }
        return implode(' ', $html);
    }
}