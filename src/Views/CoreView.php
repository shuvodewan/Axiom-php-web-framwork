<?php

namespace Axiom\Views;

/**
 * CoreView class.
 *
 * This class extends the base View class and provides a default implementation
 * for the `composer` method, which can be overridden by child classes to provide
 * additional data to the view.
 */
class CoreView extends View
{
    /**
     * Provides additional data to the view.
     *
     * This method can be overridden by child classes to pass custom data to the view.
     *
     * @return array An associative array of data to pass to the view.
     */
    protected function composer(): array
    {
        return [];
    }
}