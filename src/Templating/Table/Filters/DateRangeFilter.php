<?php

namespace Axiom\Templating\Table\Filters;

class DateRangeFilter extends Filter
{
    public function render($theme): string
    {
        $classes = $theme->getFilterClasses();
        
        $html = '<div class="grid grid-cols-2 gap-2">';
        $html .= sprintf(
            '<input type="date" class="%s" data-filter="%s_from" placeholder="From">',
            $classes,
            $this->name
        );
        $html .= sprintf(
            '<input type="date" class="%s" data-filter="%s_to" placeholder="To">',
            $classes,
            $this->name
        );
        $html .= '</div>';
        
        return $html;
    }
}