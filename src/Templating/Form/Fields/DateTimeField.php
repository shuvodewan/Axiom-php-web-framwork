<?php

namespace Axiom\Templating\Form\Fields;

class DateTimeField extends InputField {
    protected string $inputType = 'datetime-local';
    
    public function min(string $datetime): self {
        return $this->attr('min', $datetime);
    }
    
    public function max(string $datetime): self {
        return $this->attr('max', $datetime);
    }
}