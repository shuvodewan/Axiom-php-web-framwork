<?php

namespace Axiom\Templating\Table;

class Export
{
    protected string $type;
    protected string $label;
    protected string $url;
    protected string $method;
    protected string $icon;
    
    public function __construct(string $type, string $label, array $options = [])
    {
        $this->type = $type;
        $this->label = $label;
        $this->url = $options['url'] ?? '';
        $this->method = $options['method'] ?? 'GET';
        $this->icon = $options['icon'] ?? '';
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function getLabel(): string
    {
        return $this->label;
    }
    
    public function getUrl(): string
    {
        return $this->url;
    }
    
    public function getMethod(): string
    {
        return $this->method;
    }
    
    public function getIcon(): string
    {
        return $this->icon;
    }
    
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'label' => $this->label,
            'url' => $this->url,
            'method' => $this->method,
            'icon' => $this->icon
        ];
    }
}