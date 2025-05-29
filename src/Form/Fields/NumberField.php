<?php

namespace Axiom\Form\Fields;

class NumberField extends InputField {
    protected string $inputType = 'number';
    
    public function min(int|float $value): self {
        return $this->attr('min', $value);
    }
    
    public function max(int|float $value): self {
        return $this->attr('max', $value);
    }
    
    public function step(int|float $value): self {
        return $this->attr('step', $value);
    }
}