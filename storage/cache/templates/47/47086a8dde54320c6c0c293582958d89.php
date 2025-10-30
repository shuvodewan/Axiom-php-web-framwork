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

/* layouts/frontend/partials/header.twig */
class __TwigTemplate_a8a1ce4e64b5fcae38f7b97c903f5632 extends Template
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
        yield " <header class=\"fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm\">
        <div class=\"container mx-auto px-6 py-4\">
            <nav class=\"flex items-center justify-between\">
                <div class=\"flex items-center space-x-8\">
                    <a href=\"#\" class=\"flex items-center space-x-2\">
                        <svg class=\"w-8 h-8 text-primary-600\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path d=\"M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\"></path>
                        </svg>
                        <span class=\"text-2xl font-bold bg-gradient-to-r from-primary-600 to-primary-400 bg-clip-text text-transparent\">Axiom</span>
                    </a>
                    <div class=\"hidden md:flex space-x-6\">
                        <a href=\"";
        // line 12
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('route')->getCallable()("axiom.docs", ["version" => "v1", "page" => "intruduction"]), "html", null, true);
        yield "\" class=\"font-medium text-gray-600 hover:text-primary-500 transition\">Docs</a>
                        <a href=\"#\" class=\"font-medium text-gray-600 hover:text-primary-500 transition\">Changelog</a>
                        <a href=\"#\" class=\"font-medium text-gray-600 hover:text-primary-500 transition\">Examples</a>
                        <a href=\"#\" class=\"font-medium text-gray-600 hover:text-primary-500 transition\">Blog</a>
                    </div>
                </div>
                <div class=\"flex items-center space-x-4\">
                    <a href=\"#\" class=\"hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-primary-700 bg-primary-50 hover:bg-primary-100 transition\">
                        Download
                    </a>
                    <a href=\"#\" class=\"inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition\">
                        Get Started
                    </a>
                </div>
            </nav>
        </div>
    </header>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "layouts/frontend/partials/header.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  55 => 12,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source(" <header class=\"fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm\">
        <div class=\"container mx-auto px-6 py-4\">
            <nav class=\"flex items-center justify-between\">
                <div class=\"flex items-center space-x-8\">
                    <a href=\"#\" class=\"flex items-center space-x-2\">
                        <svg class=\"w-8 h-8 text-primary-600\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path d=\"M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\"></path>
                        </svg>
                        <span class=\"text-2xl font-bold bg-gradient-to-r from-primary-600 to-primary-400 bg-clip-text text-transparent\">Axiom</span>
                    </a>
                    <div class=\"hidden md:flex space-x-6\">
                        <a href=\"{{route('axiom.docs',{version:'v1', page:'intruduction'})}}\" class=\"font-medium text-gray-600 hover:text-primary-500 transition\">Docs</a>
                        <a href=\"#\" class=\"font-medium text-gray-600 hover:text-primary-500 transition\">Changelog</a>
                        <a href=\"#\" class=\"font-medium text-gray-600 hover:text-primary-500 transition\">Examples</a>
                        <a href=\"#\" class=\"font-medium text-gray-600 hover:text-primary-500 transition\">Blog</a>
                    </div>
                </div>
                <div class=\"flex items-center space-x-4\">
                    <a href=\"#\" class=\"hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-primary-700 bg-primary-50 hover:bg-primary-100 transition\">
                        Download
                    </a>
                    <a href=\"#\" class=\"inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition\">
                        Get Started
                    </a>
                </div>
            </nav>
        </div>
    </header>", "layouts/frontend/partials/header.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/frontend/partials/header.twig");
    }
}
