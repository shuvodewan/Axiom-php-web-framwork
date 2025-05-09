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

/* layouts/frontend/partials/docheader.twig */
class __TwigTemplate_580cc696b29d97fc881269088d57a4d7 extends Template
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
        yield " <header class=\"fixed w-full z-50 bg-white border-b border-gray-200 shadow-sm\">
        <div class=\"container mx-auto px-6 py-3\">
            <div class=\"flex items-center justify-between\">
                <div class=\"flex items-center space-x-4\">
                    <a href=\"/\" class=\"flex items-center space-x-2\">
                        <svg class=\"w-7 h-7 text-primary-600\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path d=\"M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\"></path>
                        </svg>
                        <span class=\"text-xl font-bold text-gray-900\">Axiom PHP</span>
                    </a>
                    <div class=\"hidden md:flex items-center space-x-1\">
                        <span class=\"text-sm text-gray-500\">Docs</span>
                        <svg class=\"w-4 h-4 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5l7 7-7 7\"></path>
                        </svg>
                        <span class=\"text-sm font-medium text-gray-700\">Getting Started</span>
                    </div>
                </div>
                <div class=\"flex items-center space-x-4\">
                    <div class=\"relative\">
                        <button id=\"version-dropdown-button\" class=\"flex items-center space-x-1 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition\">
                            <span>v2.0</span>
                            <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 9l-7 7-7-7\"></path>
                            </svg>
                        </button>
                        <div id=\"version-dropdown\" class=\"hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-10 border border-gray-200\">
                            <div class=\"py-1\">
                                <a href=\"";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('route')->getCallable()("axiom.docs", ["version" => "v1", "page" => "intruduction"]), "html", null, true);
        yield "\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100\">V1</a>
                                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100\"></a>
                                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">v1.0</a>
                            </div>
                        </div>
                    </div>
                    <div class=\"relative hidden md:block\">
                        <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                            <svg class=\"h-4 w-4 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z\"></path>
                            </svg>
                        </div>
                        <input type=\"text\" class=\"block w-full pl-10 pr-3 py-1.5 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm\" placeholder=\"Search docs...\">
                    </div>
                    <a href=\"#\" class=\"hidden md:inline-flex items-center px-4 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition\">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </header>



    <!-- Mobile Search (hidden on desktop) -->
    <div class=\"md:hidden fixed top-16 left-0 right-0 z-40 bg-white border-b border-gray-200 px-4 py-2\">
        <div class=\"relative\">
            <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                <svg class=\"h-4 w-4 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z\"></path>
                </svg>
            </div>
            <input type=\"text\" class=\"block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm\" placeholder=\"Search docs...\">
        </div>
    </div>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "layouts/frontend/partials/docheader.twig";
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
        return array (  72 => 29,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source(" <header class=\"fixed w-full z-50 bg-white border-b border-gray-200 shadow-sm\">
        <div class=\"container mx-auto px-6 py-3\">
            <div class=\"flex items-center justify-between\">
                <div class=\"flex items-center space-x-4\">
                    <a href=\"/\" class=\"flex items-center space-x-2\">
                        <svg class=\"w-7 h-7 text-primary-600\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path d=\"M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\"></path>
                        </svg>
                        <span class=\"text-xl font-bold text-gray-900\">Axiom PHP</span>
                    </a>
                    <div class=\"hidden md:flex items-center space-x-1\">
                        <span class=\"text-sm text-gray-500\">Docs</span>
                        <svg class=\"w-4 h-4 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5l7 7-7 7\"></path>
                        </svg>
                        <span class=\"text-sm font-medium text-gray-700\">Getting Started</span>
                    </div>
                </div>
                <div class=\"flex items-center space-x-4\">
                    <div class=\"relative\">
                        <button id=\"version-dropdown-button\" class=\"flex items-center space-x-1 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition\">
                            <span>v2.0</span>
                            <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 9l-7 7-7-7\"></path>
                            </svg>
                        </button>
                        <div id=\"version-dropdown\" class=\"hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-10 border border-gray-200\">
                            <div class=\"py-1\">
                                <a href=\"{{route('axiom.docs',{version:'v1', page:'intruduction'})}}\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100\">V1</a>
                                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100\"></a>
                                <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">v1.0</a>
                            </div>
                        </div>
                    </div>
                    <div class=\"relative hidden md:block\">
                        <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                            <svg class=\"h-4 w-4 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z\"></path>
                            </svg>
                        </div>
                        <input type=\"text\" class=\"block w-full pl-10 pr-3 py-1.5 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm\" placeholder=\"Search docs...\">
                    </div>
                    <a href=\"#\" class=\"hidden md:inline-flex items-center px-4 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition\">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </header>



    <!-- Mobile Search (hidden on desktop) -->
    <div class=\"md:hidden fixed top-16 left-0 right-0 z-40 bg-white border-b border-gray-200 px-4 py-2\">
        <div class=\"relative\">
            <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                <svg class=\"h-4 w-4 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z\"></path>
                </svg>
            </div>
            <input type=\"text\" class=\"block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm\" placeholder=\"Search docs...\">
        </div>
    </div>", "layouts/frontend/partials/docheader.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/frontend/partials/docheader.twig");
    }
}
