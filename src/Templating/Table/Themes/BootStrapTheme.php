<?php

namespace Axiom\Templating\Table\Themes;

use Axiom\Templating\Table\ThemeContract;

class BootstrapTheme implements ThemeContract
{
    // Table structure
    public function getTableClasses(): string
    {
        return 'table table-striped table-hover table-bordered';
    }

    public function getTableWrapperClasses(): string
    {
        return 'table-responsive';
    }

    public function getHeaderClasses(): string
    {
        return 'thead-light';
    }

    public function getHeaderCellClasses(): string
    {
        return '';
    }

    public function getRowClasses(): string
    {
        return '';
    }

    public function getCellClasses(): string
    {
        return '';
    }

    // Pagination
    public function getPaginationClasses(): string
    {
        return 'd-flex justify-content-between align-items-center p-3';
    }

    public function getPaginationButtonClasses(): string
    {
        return 'btn btn-outline-primary mx-1';
    }

    public function getActivePaginationButtonClasses(): string
    {
        return 'btn btn-primary mx-1';
    }

    // Filters
    public function getFilterClasses(): string
    {
        return 'form-control';
    }

    public function getFilterWrapperClasses(): string
    {
        return 'mb-4 row g-3';
    }

    public function getFilterGroupClasses(): string
    {
        return 'col-md-4 col-12';
    }

    public function getFilterLabelClasses(): string
    {
        return 'form-label mb-1';
    }

    // Sorting
    public function getSortableHeaderClasses(): string
    {
        return 'sortable';
    }

    public function getAscSortIcon(): string
    {
        return '<i class="bi bi-arrow-up-short"></i>';
    }

    public function getDescSortIcon(): string
    {
        return '<i class="bi bi-arrow-down-short"></i>';
    }

    // States
    public function getLoadingIndicator(): string
    {
        return '<div class="d-flex justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>';
    }

    public function getEmptyState(): string
    {
        return '<div class="text-center p-5">
            <i class="bi bi-exclamation-circle text-muted" style="font-size: 3rem;"></i>
            <h3 class="mt-3 text-muted">No data found</h3>
            <p class="text-muted">Try adjusting your search or filter to find what you\'re looking for.</p>
        </div>';
    }

    // Actions
    public function getActionButtonClasses(): string
    {
        return 'btn btn-sm btn-outline-secondary mx-1';
    }

    public function getButtonClasses(): string
    {
        return 'btn btn-primary';
    }

    public function getButtonSecondaryClasses(): string
    {
        return 'btn btn-outline-secondary';
    }

    // Additional
    public function getSelectClasses(): string
    {
        return 'form-select';
    }

    public function getBulkActionClasses(): string
    {
        return 'd-inline-flex align-items-center gap-2';
    }

    public function toArray(): array
    {
        $methods = get_class_methods($this);
        $themeData = [];
        
        foreach ($methods as $method) {
            if (strpos($method, 'get') === 0 && $method !== 'getClassMethods') {
                $key = lcfirst(substr($method, 3));
                $themeData[$key] = $this->$method();
            }
        }
        
        return $themeData;
    }
}