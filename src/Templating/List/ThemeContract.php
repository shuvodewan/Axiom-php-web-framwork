<?php

namespace Axiom\Templating\List;

interface ThemeContract
{
    public function getTableClasses(): string;
    public function getHeaderClasses(): string;
    public function getHeaderCellClasses(): string;
    public function getRowClasses(): string;
    public function getCellClasses(): string;
    public function getPaginationClasses(): string;
    public function getFilterClasses(): string;
    public function getSortableHeaderClasses(): string;
    public function getAscSortIcon(): string;
    public function getDescSortIcon(): string;
    public function getLoadingIndicator(): string;
    public function getEmptyState(): string;
}