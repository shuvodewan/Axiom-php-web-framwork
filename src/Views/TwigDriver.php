<?php

namespace Axiom\Views;

use Axiom\Traits\InstanceTrait;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigDriver implements ViewDriverContract
{
    /** @var Environment Twig environment instance. */
    private Environment $twig;

    /**
     * Constructor.
     *
     * @param string $viewsPath Path to the views directory.
     * @param string $cachePath Path to the cache directory (optional).
     */
    public function __construct(string $viewsPath, string $cachePath = '')
    {
        $loader = new FilesystemLoader($viewsPath);
        $this->twig = new Environment($loader, [
            'cache' => $cachePath, 
            'debug' => true,      
        ]);
    }

    /**
     * Renders a Twig template.
     *
     * This method takes a template name and an array of data, processes the template name
     * to ensure it is in the correct format, and then renders the template using Twig.
     *
     * @param string $template The name of the template to render (e.g., "home.index").
     * @param array $data An associative array of data to pass to the template.
     * @return string The rendered template content as a string.
     */
    public function render(string $template, array $data = []): string
    {
        return $this->twig->render($this->getTemplateName($template), $data);
    }

    /**
     * Converts a dot-notation template name into a file path.
     *
     * This method transforms a template name written in dot notation (e.g., "home.index")
     * into a file path format (e.g., "home/index.twig") that Twig can use to locate the template file.
     *
     * @param string $template The template name in dot notation (e.g., "home.index").
     * @return string The template file path (e.g., "home/index.twig").
     */
    public function getTemplateName(string $template): string
    {
        return str_replace('.', '/', $template) . '.twig';
    }
}