<?php

namespace Axiom\Templating\Form\Fields;

use Axiom\Templating\Form\BaseField;

class SelectField extends BaseField {
    protected array $options = [];
    protected ?string $placeholder = null;
    protected bool $multiple = false;

    public function options(array $options): self {
        $this->options = $options;
        return $this;
    }

    public function placeholder(string $text): self {
        $this->placeholder = $text;
        return $this;
    }

    public function multiple(bool $multiple = true): self {
        $this->multiple = $multiple;
        return $this;
    }

    public function render(): string {
        $attributes = [
            'name' => $this->name . ($this->multiple ? '[]' : ''),
            'class' => $this->getTheme()->getSelectClasses(),
        ];

        if ($this->required) {
            $attributes['required'] = true;
        }

        if ($this->multiple) {
            $attributes['multiple'] = true;
        }

        // Build options HTML
        $optionsHtml = '';

        if ($this->placeholder) {
            $optionsHtml .= sprintf(
                '<option value="" disabled %s>%s</option>',
                empty($this->value) ? 'selected' : '',
                htmlspecialchars($this->placeholder)
            );
        }

        foreach ($this->options as $value => $label) {
            $selected = is_array($this->value) 
                ? in_array($value, $this->value)
                : $value == $this->value;

            $optionsHtml .= sprintf(
                '<option value="%s" %s>%s</option>',
                htmlspecialchars($value),
                $selected ? 'selected' : '',
                htmlspecialchars($label)
            );
        }

        $selectHtml = sprintf(
            '<select %s>%s</select>',
            $this->buildAttributes($attributes),
            $optionsHtml
        );

        return $this->wrapField($selectHtml);
    }
}