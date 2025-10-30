<?php

namespace Axiom\Templating\Form\Fields;

class ColorField extends InputField {
    protected string $inputType = 'color';
    
    public function render(): string {
        $defaultAttributes = [
            'type' => $this->inputType,
            'name' => $this->name,
            'value' => $this->value ?? '#000000',
            'class' => $this->getTheme()->getInputClasses('color'),
        ];
        
        $html = sprintf('<input %s>', $this->buildAttributes($defaultAttributes));
        return $this->wrapField($html);
    }
}