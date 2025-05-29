<?php

namespace Axiom\Form;

interface ThemeContract {
    public function wrapField(string $label, string $input, ?string $helpText, array $options = []): string;
    public function getInputClasses(): string;
    public function getLabelClasses(): string;
    public function getHelpTextClasses(): string;
    public function getGroupClasses(): string;
    public function getSubmitButtonClasses(): string;
    public function getCheckboxClasses(): string;
    public function getRadioClasses(): string;
    public function wrapFileField(string $label, string $input, ?string $helpText, array $options = []): string;
    public function wrapCheckbox(string $label, string $input, ?string $helpText, array $options = []): string;
    public function wrapRadio(string $label, string $input, ?string $helpText, array $options = []): string;
}