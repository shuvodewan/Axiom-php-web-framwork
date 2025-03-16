<?php

namespace Axiom\Views;

interface ViewDriverContract
{
    /**
     * Renders a template with the provided data.
     *
     * This method takes a template name and an array of data, processes the template,
     * and returns the rendered content as a string. The exact implementation depends
     * on the driver (e.g., Twig, Blade, Plates).
     *
     * @param string $template The name of the template to render.
     * @param array $data An associative array of data to pass to the template.
     * @return string The rendered template content as a string.
     */
    public function render(string $template, array $data = []): string;

    /**
     * Converts a template name into a format suitable for the driver.
     *
     * This method transforms a template name (e.g., in dot notation) into a format
     * that the specific template driver can understand (e.g., file path, namespace).
     *
     * @param string $template The template name to transform.
     * @return string The transformed template name.
     */
    public function getTemplateName(string $template): string;
}