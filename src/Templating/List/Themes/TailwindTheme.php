<?php

namespace Axiom\Templating\List\Themes;

use Axiom\Templating\List\ThemeContract;

class TailwindTheme implements ThemeContract {
    public function getTableClasses(): string
    {
        return 'min-w-full divide-y divide-gray-200';
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
        return 'hover:bg-gray-50';
    }

    public function getCellClasses(): string
    {
        return 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
    }

    public function getPaginationClasses(): string
    {
        return 'px-6 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6';
    }

    public function getFilterClasses(): string
    {
        return 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';
    }

    public function getSortableHeaderClasses(): string
    {
        return 'cursor-pointer hover:text-gray-700';
    }

    public function getAscSortIcon(): string
    {
        return '↑';
    }

    public function getDescSortIcon(): string
    {
        return '↓';
    }

    public function getLoadingIndicator(): string
    {
        return '<div class="flex justify-center items-center p-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
        </div>';
    }

    public function getEmptyState(): string
    {
        return '<div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No data found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you\'re looking for.</p>
        </div>';
    }
}