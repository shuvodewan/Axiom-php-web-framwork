<?php

namespace Axiom\Form;

use Axiom\Facade\Str;
use Axiom\Form\Themes\TailwindTheme;
use Axiom\Form\Themes\ThemeInterface;

abstract class BaseField {
    protected string $name;
    protected string $label;
    protected mixed $value;
    protected array $attributes = [];
    protected array $validationRules = [];
    protected bool $required = false;
    protected string $helpText = '';
    protected $theme = null;
    protected ?string $groupClass = null;

    public function __construct(string $name) {
        $this->name = $name;
        $this->label = Str::title(str_replace('_', ' ', $name));
    }

    public function setTheme($theme): self 
    {
        $this->theme = $theme;
        return $this;
    }
    
    protected function getTheme()
    {
        if ($this->theme === null) {
            $this->theme = new TailwindTheme();
        }
        return $this->theme;
    }
    
    protected function wrapField(string $input): string {
        $theme = $this->getTheme();
        return $theme->wrapField(
            $this->label,
            $input,
            $this->helpText,
            ['groupClass' => $this->groupClass ?? null]
        );
    }

    abstract public function render(): string;

    public function label(string $label): self {
        $this->label = $label;
        return $this;
    }

    public function value(mixed $value): self {
        $this->value = $value;
        return $this;
    }

    public function required(bool $required = true): self {
        $this->required = $required;
        return $this;
    }

    public function helpText(string $text): self {
        $this->helpText = $text;
        return $this;
    }

    public function addValidationRule(string $rule): self {
        $this->validationRules[] = $rule;
        return $this;
    }

    public function attr(string $key, string $value): self {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function groupClass(string $class): self {
        $this->groupClass = $class;
        return $this;
    }

    protected function buildAttributes(array $defaultAttributes = []): string {
        // Use custom class if provided, otherwise use theme default
        if (isset($this->attributes['class'])) {
            $defaultAttributes['class'] = $this->attributes['class'];
            unset($this->attributes['class']);
        }

        $attributes = array_merge($defaultAttributes, $this->attributes);

        if ($this->required) {
            $attributes['required'] = 'required';
        }

        $html = [];
        foreach ($attributes as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $html[] = htmlspecialchars($key);
                }
            } elseif ($value !== null) {
                $html[] = sprintf(
                    '%s="%s"',
                    htmlspecialchars($key),
                    htmlspecialchars($value)
                );
            }
        }
        return implode(' ', $html);
    }
}