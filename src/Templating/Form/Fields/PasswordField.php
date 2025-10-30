<?php

namespace Axiom\Templating\Form\Fields;

class PasswordField extends InputField {
    protected string $inputType = 'password';
    
    public function render(): string {
        $this->value = '';
        return parent::render();
    }
}