<?php

namespace Axiom\Form\Themes;

use Axiom\Form\ThemeContract;

class TailwindTheme implements ThemeContract {
    public function formClasses(): string {
        return 'space-y-4';
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
            $helpText ? sprintf('<p class="%s">%s</p>', $this->getHelpTextClasses(), $helpText) : ''
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
                <div class="mt-1 flex items-center">
                    %s
                </div>
                %s
            </div>',
            $classes,
            $this->getLabelClasses(),
            $label,
            $input,
            $helpText ? sprintf('<p class="%s">%s</p>', $this->getHelpTextClasses(), $helpText) : ''
        );
    }

    public function wrapCheckbox(string $label, string $input, ?string $helpText, array $options = []): string {
        $classes = 'relative flex items-start ' . $this->getGroupClasses();
        if (isset($options['groupClass'])) {
            $classes .= ' ' . $options['groupClass'];
        }

        return sprintf(
            '<div class="%s">
                <div class="flex items-center h-5">
                    %s
                </div>
                <div class="ml-3 text-sm">
                    <label class="%s">%s</label>
                    %s
                </div>
            </div>',
            $classes,
            $input,
            $this->getCheckboxLabelClasses(),
            $label,
            $helpText ? sprintf('<p class="%s">%s</p>', $this->getHelpTextClasses(), $helpText) : ''
        );
    }

    public function wrapRadio(string $label, string $input, ?string $helpText, array $options = []): string {
        $classes = 'relative flex items-start ' . $this->getGroupClasses();
        if (isset($options['groupClass'])) {
            $classes .= ' ' . $options['groupClass'];
        }

        return sprintf(
            '<div class="%s">
                <div class="flex items-center h-5">
                    %s
                </div>
                <div class="ml-3 text-sm">
                    <label class="%s">%s</label>
                    %s
                </div>
            </div>',
            $classes,
            $input,
            $this->getRadioLabelClasses(),
            $label,
            $helpText ? sprintf('<p class="%s">%s</p>', $this->getHelpTextClasses(), $helpText) : ''
        );
    }

    public function getInputClasses(string $type = 'text'): string {
        $base = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
        
        // Type-specific additions
        switch ($type) {
            case 'file':
                return 'file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100';
            case 'color':
                return 'mt-1 block h-10 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
            case 'range':
                return 'mt-1 block w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer';
            default:
                return $base;
        }
    }

    public function getCheckboxClasses(): string {
        return 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500';
    }

    public function getRadioClasses(): string {
        return 'h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500';
    }

    public function getLabelClasses(): string {
        return 'block text-sm font-medium text-gray-700';
    }

    public function getCheckboxLabelClasses(): string {
        return 'font-medium text-gray-700';
    }

    public function getRadioLabelClasses(): string {
        return 'font-medium text-gray-700';
    }

    public function getHelpTextClasses(): string {
        return 'mt-2 text-sm text-gray-500';
    }

    public function getGroupClasses(): string {
        return 'mb-4';
    }

    public function getSubmitButtonClasses(): string {
        return 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
    }

    public function getSelectClasses(): string {
        return 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md';
    }

    public function getTextareaClasses(): string {
        return 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
    }

    public function wrapSelectField(string $label, string $input, ?string $helpText, array $options = []): string {
        return $this->wrapField($label, $input, $helpText, $options);
    }

    public function wrapTextareaField(string $label, string $input, ?string $helpText, array $options = []): string {
        return $this->wrapField($label, $input, $helpText, $options);
    }
}