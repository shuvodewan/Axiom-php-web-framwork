<?php

namespace Axiom\Templating\Table;

class Action
{
    protected string $name;
    protected string $label;
    protected string $url;
    protected string $method;
    protected string $icon;
    protected string $classes;
    protected string $confirm;
    
    public function __construct(string $name, string $label, array $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->url = $options['url'] ?? '';
        $this->method = $options['method'] ?? 'GET';
        $this->icon = $options['icon'] ?? '';
        $this->classes = $options['classes'] ?? '';
        $this->confirm = $options['confirm'] ?? '';
    }
    
    public function render($theme, array $row = []): string
    {
        $url = $this->replacePlaceholders($this->url, $row);
        
        $html = '<button class="' . $theme->getActionButtonClasses() . ' ' . $this->classes . '"';
        
        if ($this->confirm) {
            $html .= ' onclick="return confirm(\'' . addslashes($this->confirm) . '\')"';
        }
        
        $html .= ' data-action="' . $this->name . '"';
        $html .= ' data-url="' . htmlspecialchars($url) . '"';
        $html .= ' data-method="' . $this->method . '"';
        $html .= '>';
        
        if ($this->icon) {
            $html .= $this->icon . ' ';
        }
        
        $html .= $this->label;
        $html .= '</button>';
        
        return $html;
    }
    
    public function renderTemplate($theme): string
    {
        $html = '<button class="' . $theme->getActionButtonClasses() . ' ' . $this->classes . '"';
        
        if ($this->confirm) {
            $html .= ' @click="confirmAction(\'' . $this->name . '\', row.id)"';
        } else {
            $html .= ' @click="executeAction(\'' . $this->name . '\', row.id)"';
        }
        
        $html .= '>';
        
        if ($this->icon) {
            $html .= $this->icon . ' ';
        }
        
        $html .= $this->label;
        $html .= '</button>';
        
        return $html;
    }
    
    protected function replacePlaceholders(string $url, array $row): string
    {
        foreach ($row as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }
        return $url;
    }
    
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'url' => $this->url,
            'method' => $this->method,
            'icon' => $this->icon,
            'classes' => $this->classes,
            'confirm' => $this->confirm
        ];
    }
}