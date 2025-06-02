<?php

namespace Axiom\Templating\Form\Fields;

class HiddenField extends InputField {
    protected string $inputType = 'hidden';
    
    public function render(): string {
        // Hidden fields don't need wrapping
        $attributes = [
            'type' => $this->inputType,
            'name' => $this->name,
            'value' => $this->value ?? '',
        ];
        
        return sprintf('<input %s>', $this->buildAttributes($attributes));
    }
}