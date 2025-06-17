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

/* layouts/backend/partials/sidebar.twig */
class __TwigTemplate_6cdc182cb2576fd1d3d91b69daa7a83e extends Template
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
        yield " <aside class=\"sidebar fixed top-0 left-0 h-full w-64 bg-white shadow-md z-50\">
        <!-- Sidebar Header -->
        <div class=\"sidebar-header flex items-center justify-between p-4 border-b border-gray-200\">
            <div class=\"flex items-center\">
                <div class=\"w-8 h-8 bg-blue-600 rounded-md flex items-center justify-center text-white\">
                    <i class=\"fas fa-cube\"></i>
                </div>
                <span class=\"sidebar-header-text ml-3 font-semibold text-lg\">";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('config')->getCallable()("app.name"), "html", null, true);
        yield "</span>
            </div>
            <button id=\"toggleSidebar\" class=\"text-gray-500 hover:text-gray-700\">
                <i class=\"fas fa-bars\"></i>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <nav class=\"p-4\">
            <div class=\"mb-6\">
                <p class=\"sidebar-header-text uppercase text-xs font-semibold text-gray-500 mb-3\">Main</p>
                <ul>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100 active\">
                            <i class=\"fas fa-tachometer-alt\"></i>
                            <span class=\"sidebar-item-text ml-3\">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-users\"></i>
                            <span class=\"sidebar-item-text ml-3\">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-box\"></i>
                            <span class=\"sidebar-item-text ml-3\">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-shopping-cart\"></i>
                            <span class=\"sidebar-item-text ml-3\">Orders</span>
                            <span class=\"ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full\">15</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class=\"mb-6\">
                <p class=\"sidebar-header-text uppercase text-xs font-semibold text-gray-500 mb-3\">Management</p>
                <ul>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-cog\"></i>
                            <span class=\"sidebar-item-text ml-3\">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-user-shield\"></i>
                            <span class=\"sidebar-item-text ml-3\">Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-file-alt\"></i>
                            <span class=\"sidebar-item-text ml-3\">Reports</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class=\"sidebar-header-text uppercase text-xs font-semibold text-gray-500 mb-3\">Support</p>
                <ul>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-question-circle\"></i>
                            <span class=\"sidebar-item-text ml-3\">Help Center</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-book\"></i>
                            <span class=\"sidebar-item-text ml-3\">Documentation</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class=\"absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200\">
            <div class=\"flex items-center\">
                <img src=\"https://i.pravatar.cc/150?img=5\" alt=\"User\" class=\"w-8 h-8 rounded-full\">
                <div class=\"sidebar-header-text ml-3\">
                    <p class=\"text-sm font-medium text-gray-700\">Admin User</p>
                    <p class=\"text-xs text-gray-500\">admin@example.com</p>
                </div>
                <button class=\"ml-auto text-gray-500 hover:text-gray-700\">
                    <i class=\"fas fa-sign-out-alt\"></i>
                </button>
            </div>
        </div>
    </aside>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "layouts/backend/partials/sidebar.twig";
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
        return array (  51 => 8,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source(" <aside class=\"sidebar fixed top-0 left-0 h-full w-64 bg-white shadow-md z-50\">
        <!-- Sidebar Header -->
        <div class=\"sidebar-header flex items-center justify-between p-4 border-b border-gray-200\">
            <div class=\"flex items-center\">
                <div class=\"w-8 h-8 bg-blue-600 rounded-md flex items-center justify-center text-white\">
                    <i class=\"fas fa-cube\"></i>
                </div>
                <span class=\"sidebar-header-text ml-3 font-semibold text-lg\">{{config('app.name')}}</span>
            </div>
            <button id=\"toggleSidebar\" class=\"text-gray-500 hover:text-gray-700\">
                <i class=\"fas fa-bars\"></i>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <nav class=\"p-4\">
            <div class=\"mb-6\">
                <p class=\"sidebar-header-text uppercase text-xs font-semibold text-gray-500 mb-3\">Main</p>
                <ul>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100 active\">
                            <i class=\"fas fa-tachometer-alt\"></i>
                            <span class=\"sidebar-item-text ml-3\">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-users\"></i>
                            <span class=\"sidebar-item-text ml-3\">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-box\"></i>
                            <span class=\"sidebar-item-text ml-3\">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-shopping-cart\"></i>
                            <span class=\"sidebar-item-text ml-3\">Orders</span>
                            <span class=\"ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full\">15</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class=\"mb-6\">
                <p class=\"sidebar-header-text uppercase text-xs font-semibold text-gray-500 mb-3\">Management</p>
                <ul>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-cog\"></i>
                            <span class=\"sidebar-item-text ml-3\">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-user-shield\"></i>
                            <span class=\"sidebar-item-text ml-3\">Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-file-alt\"></i>
                            <span class=\"sidebar-item-text ml-3\">Reports</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class=\"sidebar-header-text uppercase text-xs font-semibold text-gray-500 mb-3\">Support</p>
                <ul>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-question-circle\"></i>
                            <span class=\"sidebar-item-text ml-3\">Help Center</span>
                        </a>
                    </li>
                    <li>
                        <a href=\"#\" class=\"sidebar-item flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100\">
                            <i class=\"fas fa-book\"></i>
                            <span class=\"sidebar-item-text ml-3\">Documentation</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class=\"absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200\">
            <div class=\"flex items-center\">
                <img src=\"https://i.pravatar.cc/150?img=5\" alt=\"User\" class=\"w-8 h-8 rounded-full\">
                <div class=\"sidebar-header-text ml-3\">
                    <p class=\"text-sm font-medium text-gray-700\">Admin User</p>
                    <p class=\"text-xs text-gray-500\">admin@example.com</p>
                </div>
                <button class=\"ml-auto text-gray-500 hover:text-gray-700\">
                    <i class=\"fas fa-sign-out-alt\"></i>
                </button>
            </div>
        </div>
    </aside>
", "layouts/backend/partials/sidebar.twig", "/home/volk/project/rnd/laravel/project/templates/layouts/backend/partials/sidebar.twig");
    }
}
