<?php

namespace Axiom\Templating\Table\Filters;

class DateFilter extends Filter
{
    public function render($theme): string
    {
        $classes = $theme->getFilterClasses();
        $placeholder = $this->options['placeholder'] ?? 'Select date...';
        
        return sprintf(
            '<input type="date" class="%s" data-filter="%s" placeholder="%s">',
            $classes,
            $this->name,
            htmlspecialchars($placeholder)
        );
    }
}