<?php

namespace Axiom\Views;

use Axiom\Application\AppManager;
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
    public function __construct()
    {
        $loader = new FilesystemLoader();
        $loader->addPath(project_path('/templates'));
        $this->registerTempltes($loader);
        $this->twig = new Environment($loader, [
            'cache' => storage_path('/cache/templates'), 
            'debug' => true,      
        ]);
        $this->register();
    }

    public function registerTempltes($loader)
    {
        // foreach((new AppManager())->getTemplatesDirs() as $dir){
        //     $loader->addPath($dir); 
        // }
    }


    /**
     * Registers the Twig extension with the environment.
     *
     * Adds the custom TwigExtension to provide additional functions and filters.
     * 
     * @return self Returns the instance for method chaining.
     */
    public function register()
    {
        $this->twig->addExtension(new TwigExtension($this->twig));
        return $this;
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