<?php

namespace Axiom\Templating\Table\Filters;

class NumberFilter extends Filter
{
    public function render($theme): string
    {
        $classes = $theme->getFilterClasses();
        $placeholder = $this->options['placeholder'] ?? 'Enter number...';
        
        return sprintf(
            '<input type="number" class="%s" data-filter="%s" placeholder="%s">',
            $classes,
            $this->name,
            htmlspecialchars($placeholder)
        );
    }
}