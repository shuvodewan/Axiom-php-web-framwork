<?php

namespace Axiom\Application\Base;

use Axiom\Facade\Request;
use Axiom\Http\Response;
use Axiom\Views\CoreView;

/**
 * Base controller class providing common functionality for all controllers.
 * 
 * Offers request handling, service injection, view rendering, and response generation.
 */
class Controller 
{
    /**
     * The service class associated with this controller.
     * Should be a fully qualified class name if service is needed.
     * 
     * @var string|null
     */
    protected $serviceable = null;

    /**
     * The current HTTP request instance.
     * 
     * @var Request
     */
    protected Request $request;

    /**
     * Optional message for responses or operations.
     * 
     * @var string|null
     */
    protected ?string $message = null;

    /**
     * The service instance if serviceable is set.
     * 
     * @var object|null
     */
    protected ?object $service = null;

    /**
     * The view class to be used for rendering.
     * Defaults to CoreView.
     * 
     * @var string
     */
    protected string $view = CoreView::class;

    /**
     * Controller constructor.
     * 
     * Initializes the request object and optionally creates a service instance
     * if $serviceable property is set.
     */
    public function __construct()
    {
        $this->request = new Request();

        if ($service = $this->serviceable) {
            $this->service = $service::initiate();
        }
    }

    /**
     * Renders a view template with the provided data.
     * 
     * @param string $template The template file to render
     * @param array $data Associative array of data to pass to the view
     * @return self Returns the controller instance for method chaining
     */
    protected function view(string $template, array $data = []): self
    {
        (new $this->view())->render($template, $data);
        return $this;
    }

    /**
     * Magic getter method for dynamic property access.
     * 
     * Currently supports getting a Response instance via 'response' property.
     * 
     * @param string $name The property name being accessed
     * @return Response|null Returns a Response instance or null if property doesn't exist
     */
    public function __get(string $name): ?Response
    {
        if ($name === 'response') {
            return new Response();
        }
        return null;
    }
}