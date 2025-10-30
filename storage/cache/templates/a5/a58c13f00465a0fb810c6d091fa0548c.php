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
class __TwigTemplate_dfe9c0421f05b39972e03d6b7a1e9eda extends Template
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
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield " <header class=\"sticky top-0 z-10 bg-white border-b border-gray-200 shadow-sm\">
    <div class=\"flex items-center justify-between p-4\">
        <div class=\"flex items-center space-x-4\">
            <h1 class=\"text-xl font-semibold text-gray-800\">Dashboard</h1>
        </div>
        
        <div class=\"flex items-center space-x-4\">
            <div class=\"relative\">
                <button class=\"p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full\">
                    <i class=\"fas fa-bell\"></i>
                    <span class=\"absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full\"></span>
                </button>
            </div>
            <div class=\"relative\">
                <button class=\"p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full\">
                    <i class=\"fas fa-envelope\"></i>
                    <span class=\"absolute top-0 right-0 w-2 h-2 bg-primary-500 rounded-full\"></span>
                </button>
            </div>
            <div class=\"flex items-center space-x-2\">
                <div class=\"w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center\">
                    <i class=\"fas fa-user text-primary-600\"></i>
                </div>
                <span class=\"hidden md:inline-block font-medium\">John Doe</span>
            </div>
        </div>
    </div>
</header>";
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
        return array (  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source(" <header class=\"sticky top-0 z-10 bg-white border-b border-gray-200 shadow-sm\">
    <div class=\"flex items-center justify-between p-4\">
        <div class=\"flex items-center space-x-4\">
            <h1 class=\"text-xl font-semibold text-gray-800\">Dashboard</h1>
        </div>
        
        <div class=\"flex items-center space-x-4\">
            <div class=\"relative\">
                <button class=\"p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full\">
                    <i class=\"fas fa-bell\"></i>
                    <span class=\"absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full\"></span>
                </button>
            </div>
            <div class=\"relative\">
                <button class=\"p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full\">
                    <i class=\"fas fa-envelope\"></i>
                    <span class=\"absolute top-0 right-0 w-2 h-2 bg-primary-500 rounded-full\"></span>
                </button>
            </div>
            <div class=\"flex items-center space-x-2\">
                <div class=\"w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center\">
                    <i class=\"fas fa-user text-primary-600\"></i>
                </div>
                <span class=\"hidden md:inline-block font-medium\">John Doe</span>
            </div>
        </div>
    </div>
</header>", "layouts/backend/partials/topbar.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/backend/partials/topbar.twig");
    }
}
