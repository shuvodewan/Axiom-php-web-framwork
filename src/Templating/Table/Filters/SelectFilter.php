<?php

namespace Axiom\Templating\Table\Filters;

class SelectFilter extends Filter
{
    public function render($theme): string
    {
        $classes = $theme->getFilterClasses();
        $placeholder = $this->options['placeholder'] ?? 'Select...';
        $options = $this->options['options'] ?? [];
        
        $html = sprintf(
            '<select class="%s" data-filter="%s">',
            $classes,
            $this->name
        );
        
        $html .= sprintf('<option value="">%s</option>', htmlspecialchars($placeholder));
        
        foreach ($options as $value => $label) {
            $html .= sprintf(
                '<option value="%s">%s</option>',
                htmlspecialchars($value),
                htmlspecialchars($label)
            );
        }
        
        $html .= '</select>';
        return $html;
    }
}