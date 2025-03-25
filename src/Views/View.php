<?php

namespace Axiom\Views;

use Axiom\Http\Response;

/**
 * Abstract base class for rendering views.
 *
 * This class provides a foundation for rendering views using a template engine (e.g., Twig).
 * It allows for composing data and rendering templates with ease.
 */
abstract class View
{
    /**
     * Composes additional data to be passed to the view.
     *
     * This method should be implemented by child classes to provide additional data
     * that will be merged with the data passed to the `render` method.
     *
     * @return array An associative array of data to be passed to the view.
     */
    abstract protected function composer(): array;

    /**
     * Renders a view template.
     *
     * This method merges the provided data with the data from the `composer` method,
     * renders the template using the configured template driver, and sends the response.
     *
     * @param string $template The name of the template to render.
     * @param array $data An associative array of data to pass to the template.
     */
    public function render(string $template, array $data = []): void
    {
        Response::getInstance()->view(
            $this->getTemplateData($template, [...$data, ...$this->composer()])
        )->send();
    }

    /**
     * Retrieves the rendered template content.
     *
     * This method uses the configured template driver to render the template with the provided data.
     *
     * @param string $template The name of the template to render.
     * @param array $data An associative array of data to pass to the template.
     * @return string The rendered template content.
     */
    private function getTemplateData(string $template, array $data): string
    {
        return (new TwigDriver(project_path('/templates'),storage_path('/cache/templates')))->render($template, $data);
    }

    /**
     * Initializes a new instance of the view.
     *
     * This is a factory method that allows for convenient instantiation of the view class.
     *
     * @return static A new instance of the view class.
     */
    public static function init(): static
    {
        return new static();
    }
}