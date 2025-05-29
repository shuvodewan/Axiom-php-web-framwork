<?php

namespace Axiom\Form\Fields;

class RadioField extends InputField {
    protected string $inputType = 'radio';
    
    public function render(): string {
        $attributes = [
            'type' => $this->inputType,
            'name' => $this->name,
            'value' => $this->value ?? '',
            'class' => $this->getTheme()->getRadioClasses(),
        ];
        
        if ($this->value !== null) {
            $attributes['checked'] = true;
        }
        
        $input = sprintf('<input %s>', $this->buildAttributes($attributes));
        
        // Radios typically have labels after the input
        $theme = $this->getTheme();
        return $theme->wrapRadio(
            $this->label,
            $input,
            $this->helpText,
            ['groupClass' => $this->groupClass ?? null]
        );
    }
}