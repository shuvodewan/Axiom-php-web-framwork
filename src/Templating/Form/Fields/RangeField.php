<?php

namespace Axiom\Templating\Form\Fields;

class RangeField extends InputField {
    protected string $inputType = 'range';
    
    public function min(int|float $value): self {
        return $this->attr('min', $value);
    }
    
    public function max(int|float $value): self {
        return $this->attr('max', $value);
    }
    
    public function step(int|float $value): self {
        return $this->attr('step', $value);
    }
    
    public function render(): string {
        $defaultAttributes = [
            'type' => $this->inputType,
            'name' => $this->name,
            'value' => $this->value ?? '50',
            'class' => $this->getTheme()->getInputClasses('range'),
        ];
        
        $html = sprintf('<input %s>', $this->buildAttributes($defaultAttributes));
        return $this->wrapField($html);
    }
}
