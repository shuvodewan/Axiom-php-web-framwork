<?php

namespace Axiom\Form\Fields;

use Axiom\Form\BaseField;

class TextAreaField extends BaseField {
    protected int $rows = 3;
    protected int $cols = 30;

    public function rows(int $rows): self {
        $this->rows = $rows;
        return $this;
    }

    public function cols(int $cols): self {
        $this->cols = $cols;
        return $this;
    }

    public function render(): string {
        $attributes = [
            'name' => $this->name,
            'rows' => $this->rows,
            'cols' => $this->cols,
            'class' => $this->getTheme()->getTextareaClasses(),
        ];

        if ($this->required) {
            $attributes['required'] = true;
        }

        $textareaHtml = sprintf(
            '<textarea %s>%s</textarea>',
            $this->buildAttributes($attributes),
            htmlspecialchars($this->value ?? '')
        );

        return $this->wrapField($textareaHtml);
    }
}