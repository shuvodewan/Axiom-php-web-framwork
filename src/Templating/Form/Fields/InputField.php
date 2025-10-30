<?php

namespace Axiom\Templating\Form\Fields;

use Axiom\Templating\Form\BaseField;

abstract class InputField extends BaseField {
    protected string $inputType;

    public function render(): string {
        $defaultAttributes = [
            'type' => $this->inputType,
            'name' => $this->name,
            'value' => $this->value ?? '',
            'class' => $this->getTheme()->getInputClasses($this->inputType),
        ];

        $html = sprintf('<input %s>', $this->buildAttributes($defaultAttributes));
        return $this->wrapField($html);
    }
}