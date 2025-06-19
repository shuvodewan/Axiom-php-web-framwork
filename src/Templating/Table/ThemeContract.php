<?php

namespace Axiom\Templating\Table;

interface ThemeContract
{
    /* Table Structure */
    public function getTableClasses(): string;
    public function getTableWrapperClasses(): string;
    public function getTableContainerClasses(): string;
    
    /* Header */
    public function getHeaderClasses(): string;
    public function getHeaderCellClasses(): string;
    public function getHeaderCheckboxCellClasses(): string;
    public function getHeaderActionsCellClasses(): string;
    
    /* Rows & Cells */
    public function getRowClasses(): string;
    public function getCellClasses(): string;
    public function getCellTextClasses(): string;
    public function getActionsCellClasses(): string;
    public function getActionsWrapperClasses(): string;
    
    /* Checkboxes */
    public function getCheckboxClasses(): string;
    
    /* Filters */
    public function getFilterWrapperClasses(): string;
    public function getFilterGroupClasses(): string;
    public function getFilterIconWrapperClasses(): string;
    public function getFilterSearchIconClasses(): string;
    public function getFilterDropdownIconWrapperClasses(): string;
    public function getFilterDropdownIconClasses(): string;
    public function getFilterActionsWrapperClasses(): string;
    public function getFilterActionButtonClasses(): string;
    public function getFilterRefreshIconClasses(): string;
    
    /* Avatar Components */
    public function getAvatarWrapperClasses(): string;
    public function getAvatarImageWrapperClasses(): string;
    public function getAvatarImageClasses(): string;
    public function getAvatarContentClasses(): string;
    public function getAvatarPrimaryTextClasses(): string;
    public function getAvatarSecondaryTextClasses(): string;
    
    /* Status Indicators */
    public function getStatusActiveClasses(): string;
    public function getStatusInactiveClasses(): string;
    public function getStatusPendingClasses(): string;
    public function getStatusDefaultClasses(): string;
    
    /* Pagination */
    public function getPaginationWrapperClasses(): string;
    public function getPaginationInfoWrapperClasses(): string;
    public function getPaginationInfoHighlightClasses(): string;
    public function getPaginationButtonsWrapperClasses(): string;
    public function getPaginationButtonClasses(): string;
    public function getPaginationButtonActiveClasses(): string;
    public function getPaginationButtonDisabledClasses(): string;
    public function getPaginationPrevIconClasses(): string;
    public function getPaginationNextIconClasses(): string;
    
    /* Loading & Empty States */
    public function getLoadingIndicator(): string;
    public function getEmptyState(): string;
    
    /* Action Buttons */
    public function getActionButtonClasses(): string;
    public function getButtonClasses(): string;
    public function getButtonSecondaryClasses(): string;
    
    /* Form Elements */
    public function getSelectClasses(): string;
    public function getBulkActionClasses(): string;
    
    /* Sorting */
    public function getSortableHeaderClasses(): string;
    public function getAscSortIcon(): string;
    public function getDescSortIcon(): string;
    
    /* Utility */
    public function toArray(): array;
}