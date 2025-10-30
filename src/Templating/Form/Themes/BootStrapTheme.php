<?php

namespace Axiom\Templating\Form\Themes;

use Axiom\Templating\Form\ThemeContract;

class BootstrapTheme implements ThemeContract {
    public function formClasses(): string {
        return 'needs-validation';
    }

    public function wrapField(string $label, string $input, ?string $helpText, array $options = []): string {
        $classes = $this->getGroupClasses();
        if (isset($options['groupClass'])) {
            $classes .= ' ' . $options['groupClass'];
        }

        return sprintf(
            '<div class="%s">
                <label class="%s">%s</label>
                %s
                %s
            </div>',
            $classes,
            $this->getLabelClasses(),
            $label,
            $input,
            $helpText ? sprintf('<small class="%s">%s</small>', $this->getHelpTextClasses(), $helpText) : ''
        );
    }

    public function wrapFileField(string $label, string $input, ?string $helpText, array $options = []): string {
        $classes = $this->getGroupClasses();
        if (isset($options['groupClass'])) {
            $classes .= ' ' . $options['groupClass'];
        }

        return sprintf(
            '<div class="%s">
                <label class="%s">%s</label>
                %s
                %s
            </div>',
            $classes,
            $this->getLabelClasses(),
            $label,
            $input,
            $helpText ? sprintf('<small class="%s">%s</small>', $this->getHelpTextClasses(), $helpText) : ''
        );
    }

    public function wrapCheckbox(string $label, string $input, ?string $helpText, array $options = []): string {
        $classes = 'form-check ' . $this->getGroupClasses();
        if (isset($options['groupClass'])) {
            $classes .= ' ' . $options['groupClass'];
        }

        return sprintf(
            '<div class="%s">
                %s
                <label class="%s">%s</label>
                %s
            </div>',
            $classes,
            $input,
            $this->getCheckboxLabelClasses(),
            $label,
            $helpText ? sprintf('<small class="%s">%s</small>', $this->getHelpTextClasses(), $helpText) : ''
        );
    }

    public function wrapRadio(string $label, string $input, ?string $helpText, array $options = []): string {
        $classes = 'form-check ' . $this->getGroupClasses();
        if (isset($options['groupClass'])) {
            $classes .= ' ' . $options['groupClass'];
        }

        return sprintf(
            '<div class="%s">
                %s
                <label class="%s">%s</label>
                %s
            </div>',
            $classes,
            $input,
            $this->getRadioLabelClasses(),
            $label,
            $helpText ? sprintf('<small class="%s">%s</small>', $this->getHelpTextClasses(), $helpText) : ''
        );
    }

    public function getInputClasses(string $type = 'text'): string {
        $base = 'form-control';
        
        // Type-specific additions
        switch ($type) {
            case 'file':
                return 'form-control-file';
            case 'color':
                return 'form-control form-control-color';
            case 'range':
                return 'form-range';
            default:
                return $base;
        }
    }

    public function getCheckboxClasses(): string {
        return 'form-check-input';
    }

    public function getRadioClasses(): string {
        return 'form-check-input';
    }

    public function getLabelClasses(): string {
        return 'form-label';
    }

    public function getCheckboxLabelClasses(): string {
        return 'form-check-label';
    }

    public function getRadioLabelClasses(): string {
        return 'form-check-label';
    }

    public function getHelpTextClasses(): string {
        return 'form-text text-muted';
    }

    public function getGroupClasses(): string {
        return 'mb-3';
    }

    public function getSubmitButtonClasses(): string {
        return 'btn btn-primary';
    }

    public function getSelectClasses(): string {
        return 'form-select';
    }

    public function getTextareaClasses(): string {
        return 'form-control';
    }

    public function wrapSelectField(string $label, string $input, ?string $helpText, array $options = []): string {
        return $this->wrapField($label, $input, $helpText, $options);
    }

    public function wrapTextareaField(string $label, string $input, ?string $helpText, array $options = []): string {
        return $this->wrapField($label, $input, $helpText, $options);
    }
}