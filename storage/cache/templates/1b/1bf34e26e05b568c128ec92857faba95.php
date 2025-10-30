<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* layouts/backend/partials/topbar.twig */
class __TwigTemplate_bc78e8c785f65e06adeb429a86afb80e extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<header class=\"topbar fixed top-0 right-0 left-0 h-16 bg-white shadow-sm z-40 flex items-center justify-between px-6\" style=\"margin-left: 260px;\">
    <h1 class=\"text-xl font-semibold text-gray-800\">";
        // line 2
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</h1>
    <div class=\"flex items-center space-x-4\">
        <button class=\"p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full\">
            <i class=\"fas fa-bell\"></i>
            <span class=\"absolute top-3 right-3 h-2 w-2 rounded-full bg-red-500\"></span>
        </button>
        <button class=\"p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full\">
            <i class=\"fas fa-envelope\"></i>
            <span class=\"absolute top-3 right-3 h-2 w-2 rounded-full bg-blue-500\"></span>
        </button>
        <div class=\"relative\">
            <button id=\"userMenuButton\" class=\"flex items-center space-x-2 focus:outline-none\">
                <img src=\"https://i.pravatar.cc/150?img=5\" alt=\"User\" class=\"w-8 h-8 rounded-full\">
                <span class=\"hidden md:inline-block\">Admin User</span>
                <i class=\"fas fa-chevron-down text-xs\"></i>
            </button>
            <div id=\"userMenu\" class=\"hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50\">
                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">Your Profile</a>
                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">Settings</a>
                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">Sign out</a>
            </div>
        </div>
    </div>
</header>";
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Dashboard";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "layouts/backend/partials/topbar.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  46 => 2,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<header class=\"topbar fixed top-0 right-0 left-0 h-16 bg-white shadow-sm z-40 flex items-center justify-between px-6\" style=\"margin-left: 260px;\">
    <h1 class=\"text-xl font-semibold text-gray-800\">{% block title %}Dashboard{% endblock %}</h1>
    <div class=\"flex items-center space-x-4\">
        <button class=\"p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full\">
            <i class=\"fas fa-bell\"></i>
            <span class=\"absolute top-3 right-3 h-2 w-2 rounded-full bg-red-500\"></span>
        </button>
        <button class=\"p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full\">
            <i class=\"fas fa-envelope\"></i>
            <span class=\"absolute top-3 right-3 h-2 w-2 rounded-full bg-blue-500\"></span>
        </button>
        <div class=\"relative\">
            <button id=\"userMenuButton\" class=\"flex items-center space-x-2 focus:outline-none\">
                <img src=\"https://i.pravatar.cc/150?img=5\" alt=\"User\" class=\"w-8 h-8 rounded-full\">
                <span class=\"hidden md:inline-block\">Admin User</span>
                <i class=\"fas fa-chevron-down text-xs\"></i>
            </button>
            <div id=\"userMenu\" class=\"hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50\">
                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">Your Profile</a>
                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">Settings</a>
                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">Sign out</a>
            </div>
        </div>
    </div>
</header>", "layouts/backend/partials/topbar.twig", "/home/volk/project/rnd/laravel/project/templates/layouts/backend/partials/topbar.twig");
    }
}
