<?php

namespace Axiom\Form\Fields;

class FileField extends InputField {
    protected string $inputType = 'file';
    
    public function accept(string $types): self {
        return $this->attr('accept', $types);
    }
    
    public function multiple(bool $multiple = true): self {
        return $this->attr('multiple', $multiple);
    }
    
    protected function wrapField(string $input): string {
        // File inputs often need different wrapping
        $theme = $this->getTheme();
        return $theme->wrapFileField(
            $this->label,
            $input,
            $this->helpText,
            ['groupClass' => $this->groupClass ?? null]
        );
    }
}