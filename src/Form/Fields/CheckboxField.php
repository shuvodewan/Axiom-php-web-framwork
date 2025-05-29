<?php

namespace Axiom\Form\Fields;

class CheckboxField extends InputField {
    protected string $inputType = 'checkbox';
    
    public function render(): string {
        $attributes = [
            'type' => $this->inputType,
            'name' => $this->name,
            'value' => $this->value ?? '1',
            'class' => $this->getTheme()->getCheckboxClasses(),
        ];
        
        if ($this->value) {
            $attributes['checked'] = true;
        }
        
        $input = sprintf('<input %s>', $this->buildAttributes($attributes));
        
        // Checkboxes typically have labels after the input
        $theme = $this->getTheme();
        return $theme->wrapCheckbox(
            $this->label,
            $input,
            $this->helpText,
            ['groupClass' => $this->groupClass ?? null]
        );
    }
}