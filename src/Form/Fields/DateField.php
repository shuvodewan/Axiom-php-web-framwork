<?php

namespace Axiom\Form\Fields;

class DateField extends InputField {
    protected string $inputType = 'date';
    
    public function min(string $date): self {
        return $this->attr('min', $date);
    }
    
    public function max(string $date): self {
        return $this->attr('max', $date);
    }
}