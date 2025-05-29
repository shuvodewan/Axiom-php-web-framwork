<?php

namespace Axiom\Form;

use Axiom\Form\Themes\TailwindTheme;

class FormBuilder {
    protected array $fields = [];
    protected string $method = 'POST';
    protected string $action = '';
    protected  $theme;
    protected string $enctype = 'multipart/form-data';
    protected array $formAttributes = [];
    protected string $submitButtonText = 'Submit';
    protected array $submitButtonAttributes = [];
    protected bool $csrfEnabled = true;
    protected string $csrfFieldName = '_token';
    protected string $csrfToken;

    public function __construct($theme = null)
    {
        $this->setTheme($theme ?? new TailwindTheme());
        $this->generateCsrfToken();
    }

    public function setTheme( $theme): self 
    {
        $this->theme = $theme;
        return $this;
    }
    
    public function getTheme()
    {
        return $this->theme;
    }

    public function open(string $action, string $method = 'POST'): self {
        $this->action = $action;
        $this->method = strtoupper($method);
        return $this;
    }

    public function addField(BaseField $field): self {
        $field->setTheme($this->theme);
        $this->fields[] = $field;
        return $this;
    }

    public function addFields(BaseField ...$fields): self {
        foreach ($fields as $field) {
            $this->addField($field);
        }
        return $this;
    }

    public function formAttr(string $name, string $value): self {
        $this->formAttributes[$name] = $value;
        return $this;
    }

    public function submitButton(string $text, array $attributes = []): self {
        $this->submitButtonText = $text;
        $this->submitButtonAttributes = $attributes;
        return $this;
    }

    public function enableCsrf(bool $enabled = true): self {
        $this->csrfEnabled = $enabled;
        return $this;
    }

    public function setCsrfFieldName(string $name): self {
        $this->csrfFieldName = $name;
        return $this;
    }

    public function setCsrfToken(string $token): self {
        $this->csrfToken = $token;
        return $this;
    }

    protected function generateCsrfToken(): string {
        if (!isset($this->csrfToken)) {
            $this->csrfToken = bin2hex(random_bytes(32));
        }
        return $this->csrfToken;
    }

    public function render(): string {
        $formClasses = $this->formAttributes['class'] ?? $this->theme->formClasses();
        
        $formAttributes = array_merge([
            'action' => htmlspecialchars($this->action),
            'method' => htmlspecialchars(strtoupper($this->method)),
            'enctype' => $this->enctype,
            'class' => $formClasses,
        ], array_filter($this->formAttributes, fn($key) => $key !== 'class', ARRAY_FILTER_USE_KEY));
    
        $fieldsHtml = implode('', array_map(function($field) {
            return $field->render();
        }, $this->fields));
    
        $buttonClasses = $this->submitButtonAttributes['class'] ?? $this->theme->getSubmitButtonClasses();
        
        $buttonAttributes = array_merge([
            'type' => 'submit',
            'class' => $buttonClasses,
        ], array_filter($this->submitButtonAttributes, fn($key) => $key !== 'class', ARRAY_FILTER_USE_KEY));
    
        $submitButton = sprintf(
            '<button %s>%s</button>',
            $this->buildAttributes($buttonAttributes),
            htmlspecialchars($this->submitButtonText)
        );
    
        // Add CSRF token if enabled
        $csrfField = $this->renderCsrfField();
    
        return sprintf(
            '<form %s>%s%s%s</form>',
            $this->buildAttributes($formAttributes),
            $csrfField,
            $fieldsHtml,
            $submitButton
        );
    }
    
    protected function renderCsrfField(): string {
        if (!$this->csrfEnabled) {
            return '';
        }
    
        return sprintf(
            '<input type="hidden" name="%s" value="%s">',
            htmlspecialchars($this->csrfFieldName),
            htmlspecialchars($this->csrfToken)
        );
    }
    
    protected function buildAttributes(array $attributes): string {
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

    public function getMethod(): string {
        return $this->method;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function getFields(): array {
        return $this->fields;
    }

    public function getCsrfToken(): string {
        return $this->csrfToken;
    }
}