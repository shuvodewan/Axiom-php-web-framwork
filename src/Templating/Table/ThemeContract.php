<?php

namespace Axiom\Templating\Table;

interface ThemeContract
{
    // Table structure
    public function getTableClasses(): string;
    public function getTableWrapperClasses(): string;
    public function getHeaderClasses(): string;
    public function getHeaderCellClasses(): string;
    public function getRowClasses(): string;
    public function getCellClasses(): string;
    
    // Pagination
    public function getPaginationClasses(): string;
    public function getPaginationButtonClasses(): string;
    public function getActivePaginationButtonClasses(): string;
    
    // Filters
    public function getFilterClasses(): string;
    public function getFilterWrapperClasses(): string;
    public function getFilterGroupClasses(): string;
    public function getFilterLabelClasses(): string;
    
    // Sorting
    public function getSortableHeaderClasses(): string;
    public function getAscSortIcon(): string;
    public function getDescSortIcon(): string;
    
    // States
    public function getLoadingIndicator(): string;
    public function getEmptyState(): string;
    
    // Actions
    public function getActionButtonClasses(): string;
    public function getButtonClasses(): string;
    public function getButtonSecondaryClasses(): string;
    
    // Additional
    public function getSelectClasses(): string;
    public function getBulkActionClasses(): string;

    public function toArray(): array;
}