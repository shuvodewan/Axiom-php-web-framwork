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

/* layouts/frontend/partials/sidebar.twig */
class __TwigTemplate_f1b5c4d06d92d7db916682c8dc23a7a4 extends Template
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
        yield "            <!-- Sidebar -->
        <div class=\"hidden lg:block fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 overflow-y-auto doc-sidebar\" style=\"top: 64px;\">
            <div class=\"px-4 py-4\">
                <div class=\"mb-6\">
                    <h3 class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3\">Getting Started</h3>
                    <ul class=\"space-y-1\">
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md active-nav-item\">
                                <span>Introduction</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Installation</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Configuration</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Directory Structure</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class=\"mb-6\">
                    <h3 class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3\">Core Concepts</h3>
                    <ul class=\"space-y-1\">
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Routing</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Middleware</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Controllers</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Views</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class=\"mb-6\">
                    <h3 class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3\">Database</h3>
                    <ul class=\"space-y-1\">
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Query Builder</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Eloquent ORM</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Migrations</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Seeding</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar overlay (hidden on desktop) -->
        <div class=\"fixed inset-0 z-20 bg-gray-900 bg-opacity-50 lg:hidden\" style=\"display: none;\" id=\"sidebar-overlay\"></div>

        <!-- Mobile sidebar (hidden on desktop) -->
        <div class=\"fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 overflow-y-auto transform -translate-x-full lg:hidden transition duration-300 ease-in-out\" style=\"top: 64px;\" id=\"mobile-sidebar\">
            <div class=\"px-4 py-4\">
                <!-- Same sidebar content as above -->
            </div>
        </div>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "layouts/frontend/partials/sidebar.twig";
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
        return new Source("            <!-- Sidebar -->
        <div class=\"hidden lg:block fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 overflow-y-auto doc-sidebar\" style=\"top: 64px;\">
            <div class=\"px-4 py-4\">
                <div class=\"mb-6\">
                    <h3 class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3\">Getting Started</h3>
                    <ul class=\"space-y-1\">
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md active-nav-item\">
                                <span>Introduction</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Installation</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Configuration</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Directory Structure</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class=\"mb-6\">
                    <h3 class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3\">Core Concepts</h3>
                    <ul class=\"space-y-1\">
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Routing</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Middleware</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Controllers</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Views</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class=\"mb-6\">
                    <h3 class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3\">Database</h3>
                    <ul class=\"space-y-1\">
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Query Builder</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Eloquent ORM</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Migrations</span>
                            </a>
                        </li>
                        <li>
                            <a href=\"#\" class=\"flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50\">
                                <span>Seeding</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar overlay (hidden on desktop) -->
        <div class=\"fixed inset-0 z-20 bg-gray-900 bg-opacity-50 lg:hidden\" style=\"display: none;\" id=\"sidebar-overlay\"></div>

        <!-- Mobile sidebar (hidden on desktop) -->
        <div class=\"fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 overflow-y-auto transform -translate-x-full lg:hidden transition duration-300 ease-in-out\" style=\"top: 64px;\" id=\"mobile-sidebar\">
            <div class=\"px-4 py-4\">
                <!-- Same sidebar content as above -->
            </div>
        </div>
", "layouts/frontend/partials/sidebar.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/frontend/partials/sidebar.twig");
    }
}
