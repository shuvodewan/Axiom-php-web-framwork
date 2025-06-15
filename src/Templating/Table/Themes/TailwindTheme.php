<?php

namespace Axiom\Templating\Table\Themes;

use Axiom\Templating\Table\ThemeContract;

class TailwindTheme implements ThemeContract 
{
    // Table Structure
    public function getTableClasses(): string
    {
        return 'min-w-full divide-y divide-gray-200 shadow-sm rounded-lg overflow-hidden';
    }

    public function getTableWrapperClasses(): string
    {
        return 'shadow rounded-lg border border-gray-200 overflow-x-auto';
    }

    public function getHeaderClasses(): string
    {
        return 'bg-gray-50';
    }

    public function getHeaderCellClasses(): string
    {
        return 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider';
    }

    public function getRowClasses(): string
    {
        return 'hover:bg-gray-50 transition-colors duration-150';
    }

    public function getCellClasses(): string
    {
        return 'px-6 py-4 whitespace-nowrap text-sm text-gray-700';
    }

    // Pagination
    public function getPaginationClasses(): string
    {
        return 'px-6 py-3 flex items-center justify-between border-t border-gray-200 bg-white';
    }

    public function getPaginationButtonClasses(): string
    {
        return 'px-3 py-1 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 border border-gray-300';
    }

    public function getActivePaginationButtonClasses(): string
    {
        return 'px-3 py-1 rounded-md text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700';
    }

    // Filters
    public function getFilterClasses(): string
    {
        return 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';
    }

    public function getFilterWrapperClasses(): string
    {
        return 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6';
    }

    public function getFilterGroupClasses(): string
    {
        return '';
    }

    public function getFilterLabelClasses(): string
    {
        return 'block text-sm font-medium text-gray-700 mb-1';
    }

    // Sorting
    public function getSortableHeaderClasses(): string
    {
        return 'cursor-pointer hover:text-gray-700 hover:bg-gray-100';
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

    // States
    public function getLoadingIndicator(): string
    {
        return '<div class="flex justify-center items-center p-12">
            <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-indigo-600"></div>
        </div>';
    }

    public function getEmptyState(): string
    {
        return '<div class="text-center py-12 px-4">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">No results found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you\'re looking for.</p>
        </div>';
    }

    // Actions
    public function getActionButtonClasses(): string
    {
        return 'inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
    }

    public function getButtonClasses(): string
    {
        return 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
    }

    public function getButtonSecondaryClasses(): string
    {
        return 'inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
    }

    // Additional
    public function getSelectClasses(): string
    {
        return 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md';
    }

    public function getBulkActionClasses(): string
    {
        return 'inline-flex items-center space-x-2';
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