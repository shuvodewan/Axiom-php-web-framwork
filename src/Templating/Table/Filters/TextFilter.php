<?php

namespace Axiom\Templating\Table\Filters;

class TextFilter extends Filter
{
    public function render($theme): string
    {
        $placeholder = $this->options['placeholder'] ?? '';
        $classes = $theme->getFilterClasses();
        
        return sprintf(
            '<input type="text" class="%s" data-filter="%s" placeholder="%s">',
            $classes,
            $this->name,
            htmlspecialchars($placeholder)
        );
    }
}