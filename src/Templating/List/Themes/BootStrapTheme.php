<?php

namespace Axiom\Templating\List\Themes;

use Axiom\Templating\List\ThemeContract;

class BootstrapTheme implements ThemeContract
{
    public function getTableClasses(): string
    {
        return 'table table-striped table-hover table-bordered';
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

    public function getPaginationClasses(): string
    {
        return 'd-flex justify-content-between align-items-center p-3';
    }

    public function getFilterClasses(): string
    {
        return 'form-control';
    }

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

    // Additional Bootstrap-specific methods
    public function getTableWrapperClasses(): string
    {
        return 'table-responsive';
    }

    public function getFilterWrapperClasses(): string
    {
        return 'mb-3 row g-3';
    }

    public function getFilterGroupClasses(): string
    {
        return 'col-md-4';
    }

    public function getFilterLabelClasses(): string
    {
        return 'form-label';
    }

    public function getPaginationButtonClasses(): string
    {
        return 'btn btn-outline-primary';
    }

    public function getActivePaginationButtonClasses(): string
    {
        return 'btn btn-primary';
    }
}