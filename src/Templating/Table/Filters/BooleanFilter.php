<?php

namespace Axiom\Templating\Table\Filters;

class BooleanFilter extends Filter
{
    public function render($theme): string
    {
        $classes = $theme->getFilterClasses();
        
        $html = sprintf(
            '<select class="%s" data-filter="%s">',
            $classes,
            $this->name
        );
        
        $html .= '<option value="">All</option>';
        $html .= '<option value="1">Yes</option>';
        $html .= '<option value="0">No</option>';
        $html .= '</select>';
        
        return $html;
    }
}