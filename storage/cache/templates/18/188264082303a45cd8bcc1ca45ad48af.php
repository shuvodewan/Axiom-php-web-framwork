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
class __TwigTemplate_6d5606339ef9f535bb35a053b9763134 extends Template
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
        yield " <!-- Sidebar -->
    <aside class=\"sidebar fixed top-0 left-0 z-20 h-screen w-64 bg-white border-r border-gray-200 shadow-sm\">
        <!-- Logo -->
        <div class=\"flex items-center justify-between p-4 border-b border-gray-200\">
            <div class=\"flex items-center space-x-2\">
                <div class=\"w-8 h-8 rounded-lg bg-primary-500 flex items-center justify-center\">
                    <i class=\"fas fa-cube text-white text-sm\"></i>
                </div>
                <span class=\"logo-text text-lg font-semibold text-gray-800\">AdminPanel</span>
            </div>
            <button id=\"toggleSidebar\" class=\"text-gray-500 hover:text-gray-700\">
                <i class=\"fas fa-bars\"></i>
            </button>
        </div>
        
        <!-- Sidebar Content -->
        <div class=\"p-4 overflow-y-auto h-[calc(100vh-65px)]\">
            <ul class=\"space-y-1\">
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg bg-primary-50 text-primary-600\">
                        <i class=\"fas fa-home mr-3\"></i>
                        <span class=\"sidebar-text\">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-users mr-3\"></i>
                        <span class=\"sidebar-text\">Users</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-box mr-3\"></i>
                        <span class=\"sidebar-text\">Products</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-shopping-cart mr-3\"></i>
                        <span class=\"sidebar-text\">Orders</span>
                        <span class=\"ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full\">3</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-chart-bar mr-3\"></i>
                        <span class=\"sidebar-text\">Analytics</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-envelope mr-3\"></i>
                        <span class=\"sidebar-text\">Messages</span>
                        <span class=\"ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-primary-500 rounded-full\">5</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-cog mr-3\"></i>
                        <span class=\"sidebar-text\">Settings</span>
                    </a>
                </li>
            </ul>
            
            <div class=\"mt-8 pt-4 border-t border-gray-200\">
                <div class=\"flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 cursor-pointer\">
                    <div class=\"w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center mr-3\">
                        <i class=\"fas fa-user text-gray-500\"></i>
                    </div>
                    <div>
                        <span class=\"sidebar-text block font-medium\">John Doe</span>
                        <span class=\"sidebar-text block text-xs text-gray-500\">Admin</span>
                    </div>
                </div>
            </div>
        </div>
    </aside>";
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
    public function getDebugInfo(): array
    {
        return array (  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source(" <!-- Sidebar -->
    <aside class=\"sidebar fixed top-0 left-0 z-20 h-screen w-64 bg-white border-r border-gray-200 shadow-sm\">
        <!-- Logo -->
        <div class=\"flex items-center justify-between p-4 border-b border-gray-200\">
            <div class=\"flex items-center space-x-2\">
                <div class=\"w-8 h-8 rounded-lg bg-primary-500 flex items-center justify-center\">
                    <i class=\"fas fa-cube text-white text-sm\"></i>
                </div>
                <span class=\"logo-text text-lg font-semibold text-gray-800\">AdminPanel</span>
            </div>
            <button id=\"toggleSidebar\" class=\"text-gray-500 hover:text-gray-700\">
                <i class=\"fas fa-bars\"></i>
            </button>
        </div>
        
        <!-- Sidebar Content -->
        <div class=\"p-4 overflow-y-auto h-[calc(100vh-65px)]\">
            <ul class=\"space-y-1\">
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg bg-primary-50 text-primary-600\">
                        <i class=\"fas fa-home mr-3\"></i>
                        <span class=\"sidebar-text\">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-users mr-3\"></i>
                        <span class=\"sidebar-text\">Users</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-box mr-3\"></i>
                        <span class=\"sidebar-text\">Products</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-shopping-cart mr-3\"></i>
                        <span class=\"sidebar-text\">Orders</span>
                        <span class=\"ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full\">3</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-chart-bar mr-3\"></i>
                        <span class=\"sidebar-text\">Analytics</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-envelope mr-3\"></i>
                        <span class=\"sidebar-text\">Messages</span>
                        <span class=\"ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-primary-500 rounded-full\">5</span>
                    </a>
                </li>
                <li>
                    <a href=\"#\" class=\"sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100\">
                        <i class=\"fas fa-cog mr-3\"></i>
                        <span class=\"sidebar-text\">Settings</span>
                    </a>
                </li>
            </ul>
            
            <div class=\"mt-8 pt-4 border-t border-gray-200\">
                <div class=\"flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 cursor-pointer\">
                    <div class=\"w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center mr-3\">
                        <i class=\"fas fa-user text-gray-500\"></i>
                    </div>
                    <div>
                        <span class=\"sidebar-text block font-medium\">John Doe</span>
                        <span class=\"sidebar-text block text-xs text-gray-500\">Admin</span>
                    </div>
                </div>
            </div>
        </div>
    </aside>", "layouts/backend/partials/sidebar.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/backend/partials/sidebar.twig");
    }
}
