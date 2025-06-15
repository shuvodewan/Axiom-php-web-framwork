<?php

namespace Axiom\Templating\Table;

class BulkAction
{
    protected string $name;
    protected string $label;
    protected string $url;
    protected string $method;
    protected string $confirm;
    
    public function __construct(string $name, string $label, array $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->url = $options['url'] ?? '';
        $this->method = $options['method'] ?? 'POST';
        $this->confirm = $options['confirm'] ?? '';
    }
    
    public function getName(): string
    {
        return $this->name;
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
    
    public function getConfirm(): string
    {
        return $this->confirm;
    }
    
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'url' => $this->url,
            'method' => $this->method,
            'confirm' => $this->confirm
        ];
    }
}