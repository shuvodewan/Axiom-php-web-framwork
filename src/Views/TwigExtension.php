<?php

namespace Axiom\Views;

use Axiom\Project\Registry;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

/**
 * Twig extension class that registers custom functions and filters with Twig.
 * 
 * This extension automatically registers methods from TwigMethods and TwigFilters classes,
 * as well as any functions/filters defined in the Registry.
 */
class TwigExtension extends AbstractExtension
{
    /**
     * @var array Registered Twig functions from TwigMethods class
     */
    private array $methods = [];
    
    /**
     * @var array Registered Twig filters from TwigFilters class
     */
    private array $filters = [];
    
    /**
     * @var Registry|null Application registry instance
     */
    private ?Registry $registry;
    
    /**
     * @var mixed Twig environment instance
     */
    private $twig;

    /**
     * Constructor initializes the extension and registers methods/filters.
     *
     * @param mixed $twig Twig environment instance
     */
    public function __construct($twig)
    {
        $this->registry = new Registry();
        $this->twig = $twig;
        $this->registerMethods()->registerFilters();
    }

    /**
     * Registers all public methods from TwigMethods class as Twig functions.
     *
     * Uses reflection to automatically discover and register methods.
     * 
     * @return self
     */
    private function registerMethods()
    {
        $reflection = new \ReflectionClass(TwigMethods::class);
        $instance = new TwigMethods();

        array_map(function($method) use($instance) {
            $name = $method->getName();
            $this->methods[] = new TwigFunction($name, [$instance, $name]);
        }, $reflection->getMethods(\ReflectionMethod::IS_PUBLIC));
        
        return $this;
    }

    /**
     * Registers all public methods from TwigFilters class as Twig filters.
     *
     * Uses reflection to automatically discover and register methods.
     * 
     * @return self
     */
    private function registerFilters()
    {
        $reflection = new \ReflectionClass(TwigFilters::class);
        $instance = new TwigFilters();

        array_map(function($method) use($instance) {
            $name = $method->getName();
            $this->filters[] = new TwigFilter($name, [$instance, $name]);
        }, $reflection->getMethods(\ReflectionMethod::IS_PUBLIC));
        
        return $this;
    }

    /**
     * Returns all registered Twig functions.
     *
     * Also registers any additional functions from the Registry.
     * 
     * @return array Array of TwigFunction instances
     */
    public function getFunctions(): array
    {
        foreach($this->registry->getTemplateFunctions() as $name => $func) {
            $this->twig->addFunction(new TwigFunction($name, $func));
        }

        return $this->methods;
    }

    /**
     * Returns all registered Twig filters.
     *
     * Also registers any additional filters from the Registry.
     * 
     * @return array Array of TwigFilter instances
     */
    public function getFilters(): array
    {
        foreach($this->registry->getTemplateFilters() as $name => $func) {
            $this->twig->addFunction(new TwigFilter($name, $func));
        }

        return $this->filters;
    }
}