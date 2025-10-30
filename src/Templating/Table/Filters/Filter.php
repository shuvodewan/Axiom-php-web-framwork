<?php

namespace Axiom\Templating\Table\Filters;

abstract class Filter
{
    protected string $name;
    protected string $label;
    protected string $type;
    protected array $options;
    
    public function __construct(string $name, array $options = [])
    {
        $this->name = $name;
        $this->label = $options['label'] ?? ucfirst($name);
        $this->type = $options['type'] ?? 'text';
        $this->options = $options;
    }
    
    abstract public function render($theme): string;
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getLabel(): string
    {
        return $this->label;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function getOptions(): array
    {
        return $this->options;
    }
    
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
            'options' => $this->options
        ];
    }
}