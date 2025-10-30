<?php

namespace Axiom\Templating\Table\Themes;

use Axiom\Templating\Table\ThemeContract;

class TailwindTheme implements ThemeContract
{
    //Conatiner 
    public function getContainerClass(): string {return 'bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden'; }
    // Table Structure
    public function getTableClasses(): string { return 'min-w-full divide-y divide-gray-200'; }
    public function getTableWrapperClasses(): string { return 'bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden'; }
    public function getTableContainerClasses(): string { return 'overflow-x-auto'; }
    
    // Header
    public function getHeaderClasses(): string { return 'bg-gray-50'; }
    public function getHeaderCellClasses(): string { return 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'; }
    public function getHeaderCheckboxCellClasses(): string { return 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10'; }
    public function getHeaderActionsCellClasses(): string { return 'px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider'; }
    
    // Rows & Cells
    public function getRowClasses(): string { return 'hover:bg-gray-50'; }
    public function getCellClasses(): string { return 'px-6 py-4 whitespace-nowrap'; }
    public function getCellTextClasses(): string { return 'text-sm text-gray-900'; }
    public function getActionsCellClasses(): string { return 'px-6 py-4 whitespace-nowrap text-right text-sm font-medium'; }
    public function getActionsWrapperClasses(): string { return 'flex justify-end space-x-2'; }
    
    // Checkboxes
    public function getCheckboxClasses(): string { return 'rounded border-gray-300 text-blue-600 focus:ring-blue-500'; }
    
    // Filters
    public function getFilterWrapperClasses(): string { return 'px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4'; }
    public function getFilterGroupClasses(): string { return 'relative w-full sm:w-64'; }
    public function getFilterIconWrapperClasses(): string { return 'absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none'; }
    public function getFilterSearchIconClasses(): string { return 'fas fa-search text-gray-400'; }
    public function getFilterDropdownIconWrapperClasses(): string { return 'absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none'; }
    public function getFilterDropdownIconClasses(): string { return 'fas fa-chevron-down text-gray-400'; }
    public function getFilterActionsWrapperClasses(): string { return 'flex items-center gap-3 w-full sm:w-auto'; }
    public function getFilterActionButtonClasses(): string { return 'p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors'; }
    public function getFilterRefreshIconClasses(): string { return 'fas fa-sync-alt text-gray-500'; }
    
    // Avatar
    public function getAvatarWrapperClasses(): string { return 'flex items-center'; }
    public function getAvatarImageWrapperClasses(): string { return 'flex-shrink-0 h-10 w-10'; }
    public function getAvatarImageClasses(): string { return 'h-10 w-10 rounded-full'; }
    public function getAvatarContentClasses(): string { return 'ml-4'; }
    public function getAvatarPrimaryTextClasses(): string { return 'text-sm font-medium text-gray-900'; }
    public function getAvatarSecondaryTextClasses(): string { return 'text-sm text-gray-500'; }
    
    // Status
    public function getStatusActiveClasses(): string { return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'; }
    public function getStatusInactiveClasses(): string { return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800'; }
    public function getStatusPendingClasses(): string { return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800'; }
    public function getStatusDefaultClasses(): string { return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800'; }
    
    // Pagination
    public function getPaginationWrapperClasses(): string { return 'px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4'; }
    public function getPaginationInfoWrapperClasses(): string { return 'text-sm text-gray-600'; }
    public function getPaginationInfoHighlightClasses(): string { return 'font-medium'; }
    public function getPaginationButtonsWrapperClasses(): string { return 'flex gap-2'; }
    public function getPaginationButtonClasses(): string { return 'w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors'; }
    public function getPaginationButtonActiveClasses(): string { return 'bg-blue-500 text-white'; }
    public function getPaginationButtonDisabledClasses(): string { return 'disabled:opacity-50 disabled:cursor-not-allowed'; }
    public function getPaginationPrevIconClasses(): string { return 'fas fa-chevron-left'; }
    public function getPaginationNextIconClasses(): string { return 'fas fa-chevron-right'; }
    
    // Loading & Empty States
    public function getLoadingIndicator(): string 
    { 
        return '<div class="flex justify-center items-center p-8">
            <i class="fas fa-circle-notch fa-spin text-gray-400 text-2xl"></i>
        </div>'; 
    }
    
    public function getEmptyState(): string 
    { 
        return '<div class="text-center py-8 px-4 text-gray-500">
            <i class="fas fa-inbox text-3xl mb-2"></i>
            <p>No records found</p>
        </div>'; 
    }
    
    // Action Buttons
    public function getActionButtonClasses(): string 
    { 
        return 'inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'; 
    }
    
    public function getButtonClasses(): string 
    { 
        return 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'; 
    }
    
    public function getButtonSecondaryClasses(): string 
    { 
        return 'inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'; 
    }
    
    // Form Elements
    public function getSelectClasses(): string 
    { 
        return 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md'; 
    }
    
    public function getBulkActionClasses(): string 
    { 
        return 'inline-flex items-center space-x-2'; 
    }
    
    // Sorting
    public function getSortableHeaderClasses(): string 
    { 
        return 'cursor-pointer hover:bg-gray-100'; 
    }
    
    public function getAscSortIcon(): string 
    { 
        return '<svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
        </svg>'; 
    }
    
    public function getDescSortIcon(): string 
    { 
        return '<svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>'; 
    }

    // Add this method to your TailwindTheme class
    public function getFilterClasses(): string 
    {
        return 'pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full';
    }

    // Also add getFilterLabelClasses() which was also likely missing
    public function getFilterLabelClasses(): string 
    {
        return 'block text-sm font-medium text-gray-700 mb-1';
}
    
    // Utility
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