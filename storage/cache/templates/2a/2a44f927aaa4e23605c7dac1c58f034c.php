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

/* backend/index.twig */
class __TwigTemplate_76c581fd6b165e9675d7355956d34efc extends Template
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

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "layouts/backend/app.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->load("layouts/backend/app.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "User Management";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "    <div class=\"container mx-auto px-4 py-6\">
              ";
        // line 7
        yield (is_scalar($tmp = ($context["table"] ?? null)) ? new Markup($tmp, $this->env->getCharset()) : $tmp);
        yield "
        <!-- Page Header -->
        <div class=\"flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4\">
            <div>
                <h1 class=\"text-2xl font-bold text-gray-800\">User Management</h1>
                <p class=\"text-gray-600\">Manage all registered users in your application</p>
            </div>
            <div class=\"flex gap-3\">
                <a href=\"/users/create\" class=\"inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm\">
                    <i class=\"fas fa-plus\"></i>
                    Add New User
                </a>
                <button class=\"inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors shadow-sm\">
                    <i class=\"fas fa-download\"></i>
                    Export
                </button>
            </div>
        </div>

        <!-- Table Container -->
   <div class=\"bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden\">
    <!-- Table Toolbar with Filters and Actions -->
    <div class=\"px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4\">
        <!-- Left Side: Search and Filters -->
        <div class=\"flex flex-col sm:flex-row gap-4 w-full sm:w-auto\">
            <!-- Search Input -->
            <div class=\"relative w-full sm:w-64\">
                <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                    <i class=\"fas fa-search text-gray-400\"></i>
                </div>
                <input 
                    type=\"text\" 
                    class=\"pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full\" 
                    placeholder=\"Search...\"
                >
            </div>
            
            <!-- Status Filter -->
            <div class=\"relative w-full sm:w-48\">
                <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full\">
                    <option value=\"\">All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Pending</option>
                    <option>Archived</option>
                </select>
                <div class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                    <i class=\"fas fa-chevron-down text-gray-400\"></i>
                </div>
            </div>
            
            <!-- Role Filter -->
            <div class=\"relative w-full sm:w-48\">
                <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full\">
                    <option value=\"\">All Roles</option>
                    <option>Administrator</option>
                    <option>Editor</option>
                    <option>Contributor</option>
                    <option>Viewer</option>
                </select>
                <div class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                    <i class=\"fas fa-chevron-down text-gray-400\"></i>
                </div>
            </div>
            
            <!-- Date Range Filter -->
            <div class=\"relative w-full sm:w-48\">
                <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full\">
                    <option value=\"\">All Time</option>
                    <option>Today</option>
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                    <option>Custom Range</option>
                </select>
                <div class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                    <i class=\"fas fa-calendar text-gray-400\"></i>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Actions -->
        <div class=\"flex items-center gap-3 w-full sm:w-auto\">
            <!-- Refresh Button -->
            <button class=\"p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                <i class=\"fas fa-sync-alt text-gray-500\"></i>
            </button>
            
            <!-- Export Dropdown -->
            <div class=\"relative\">
                <button class=\"flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors\">
                    <i class=\"fas fa-download text-gray-500\"></i>
                    <span class=\"text-sm\">Export</span>
                    <i class=\"fas fa-chevron-down text-gray-400 text-xs\"></i>
                </button>
                <div class=\"absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10 hidden\">
                    <div class=\"py-1\">
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-file-excel text-green-500 mr-2\"></i> Excel
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-file-pdf text-red-500 mr-2\"></i> PDF
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-file-csv text-blue-500 mr-2\"></i> CSV
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-file-alt text-gray-500 mr-2\"></i> Print
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Bulk Actions Dropdown -->
            <div class=\"relative\">
                <button class=\"flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors\">
                    <i class=\"fas fa-tasks text-gray-500\"></i>
                    <span class=\"text-sm\">Actions</span>
                    <i class=\"fas fa-chevron-down text-gray-400 text-xs\"></i>
                </button>
                <div class=\"absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10 hidden\">
                    <div class=\"py-1\">
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-user-check text-green-500 mr-2\"></i> Activate
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-user-slash text-red-500 mr-2\"></i> Deactivate
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-trash-alt text-red-500 mr-2\"></i> Delete
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-tags text-blue-500 mr-2\"></i> Assign Tags
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Content (keep your existing table structure) -->
    <div class=\"overflow-x-auto\">
        <!-- Your existing table HTML here -->
    </div>

    <!-- Enhanced Table Footer -->
    <div class=\"px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4\">
        <!-- Rows per page selector -->
        <div class=\"flex items-center gap-2\">
            <span class=\"text-sm text-gray-600\">Rows per page:</span>
            <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-3 py-1 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm\">
                <option>10</option>
                <option selected>25</option>
                <option>50</option>
                <option>100</option>
                <option>All</option>
            </select>
        </div>
        
        <!-- Pagination info -->
        <div class=\"text-sm text-gray-600\">
            Showing <span class=\"font-medium\">1</span> to <span class=\"font-medium\">10</span> of <span class=\"font-medium\">247</span> results
        </div>
        
        <!-- Pagination controls -->
        <div class=\"flex gap-2\">
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed\" disabled>
                <i class=\"fas fa-chevron-left\"></i>
            </button>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg bg-blue-500 text-white\">
                1
            </button>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                2
            </button>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                3
            </button>
            <span class=\"w-10 h-10 flex items-center justify-center\">
                ...
            </span>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                8
            </button>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                <i class=\"fas fa-chevron-right\"></i>
            </button>
        </div>
    </div>
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
        return "backend/index.twig";
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
        return array (  73 => 7,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"layouts/backend/app.twig\" %}

{% block title %}User Management{% endblock %}

{% block body %}
    <div class=\"container mx-auto px-4 py-6\">
              {{ table | raw }}
        <!-- Page Header -->
        <div class=\"flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4\">
            <div>
                <h1 class=\"text-2xl font-bold text-gray-800\">User Management</h1>
                <p class=\"text-gray-600\">Manage all registered users in your application</p>
            </div>
            <div class=\"flex gap-3\">
                <a href=\"/users/create\" class=\"inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm\">
                    <i class=\"fas fa-plus\"></i>
                    Add New User
                </a>
                <button class=\"inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors shadow-sm\">
                    <i class=\"fas fa-download\"></i>
                    Export
                </button>
            </div>
        </div>

        <!-- Table Container -->
   <div class=\"bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden\">
    <!-- Table Toolbar with Filters and Actions -->
    <div class=\"px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4\">
        <!-- Left Side: Search and Filters -->
        <div class=\"flex flex-col sm:flex-row gap-4 w-full sm:w-auto\">
            <!-- Search Input -->
            <div class=\"relative w-full sm:w-64\">
                <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                    <i class=\"fas fa-search text-gray-400\"></i>
                </div>
                <input 
                    type=\"text\" 
                    class=\"pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full\" 
                    placeholder=\"Search...\"
                >
            </div>
            
            <!-- Status Filter -->
            <div class=\"relative w-full sm:w-48\">
                <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full\">
                    <option value=\"\">All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Pending</option>
                    <option>Archived</option>
                </select>
                <div class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                    <i class=\"fas fa-chevron-down text-gray-400\"></i>
                </div>
            </div>
            
            <!-- Role Filter -->
            <div class=\"relative w-full sm:w-48\">
                <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full\">
                    <option value=\"\">All Roles</option>
                    <option>Administrator</option>
                    <option>Editor</option>
                    <option>Contributor</option>
                    <option>Viewer</option>
                </select>
                <div class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                    <i class=\"fas fa-chevron-down text-gray-400\"></i>
                </div>
            </div>
            
            <!-- Date Range Filter -->
            <div class=\"relative w-full sm:w-48\">
                <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full\">
                    <option value=\"\">All Time</option>
                    <option>Today</option>
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                    <option>Custom Range</option>
                </select>
                <div class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                    <i class=\"fas fa-calendar text-gray-400\"></i>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Actions -->
        <div class=\"flex items-center gap-3 w-full sm:w-auto\">
            <!-- Refresh Button -->
            <button class=\"p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                <i class=\"fas fa-sync-alt text-gray-500\"></i>
            </button>
            
            <!-- Export Dropdown -->
            <div class=\"relative\">
                <button class=\"flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors\">
                    <i class=\"fas fa-download text-gray-500\"></i>
                    <span class=\"text-sm\">Export</span>
                    <i class=\"fas fa-chevron-down text-gray-400 text-xs\"></i>
                </button>
                <div class=\"absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10 hidden\">
                    <div class=\"py-1\">
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-file-excel text-green-500 mr-2\"></i> Excel
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-file-pdf text-red-500 mr-2\"></i> PDF
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-file-csv text-blue-500 mr-2\"></i> CSV
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-file-alt text-gray-500 mr-2\"></i> Print
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Bulk Actions Dropdown -->
            <div class=\"relative\">
                <button class=\"flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors\">
                    <i class=\"fas fa-tasks text-gray-500\"></i>
                    <span class=\"text-sm\">Actions</span>
                    <i class=\"fas fa-chevron-down text-gray-400 text-xs\"></i>
                </button>
                <div class=\"absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10 hidden\">
                    <div class=\"py-1\">
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-user-check text-green-500 mr-2\"></i> Activate
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-user-slash text-red-500 mr-2\"></i> Deactivate
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-trash-alt text-red-500 mr-2\"></i> Delete
                        </a>
                        <a href=\"#\" class=\"block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100\">
                            <i class=\"fas fa-tags text-blue-500 mr-2\"></i> Assign Tags
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Content (keep your existing table structure) -->
    <div class=\"overflow-x-auto\">
        <!-- Your existing table HTML here -->
    </div>

    <!-- Enhanced Table Footer -->
    <div class=\"px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4\">
        <!-- Rows per page selector -->
        <div class=\"flex items-center gap-2\">
            <span class=\"text-sm text-gray-600\">Rows per page:</span>
            <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-3 py-1 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm\">
                <option>10</option>
                <option selected>25</option>
                <option>50</option>
                <option>100</option>
                <option>All</option>
            </select>
        </div>
        
        <!-- Pagination info -->
        <div class=\"text-sm text-gray-600\">
            Showing <span class=\"font-medium\">1</span> to <span class=\"font-medium\">10</span> of <span class=\"font-medium\">247</span> results
        </div>
        
        <!-- Pagination controls -->
        <div class=\"flex gap-2\">
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed\" disabled>
                <i class=\"fas fa-chevron-left\"></i>
            </button>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg bg-blue-500 text-white\">
                1
            </button>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                2
            </button>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                3
            </button>
            <span class=\"w-10 h-10 flex items-center justify-center\">
                ...
            </span>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                8
            </button>
            <button class=\"w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                <i class=\"fas fa-chevron-right\"></i>
            </button>
        </div>
    </div>
</div>
    </div>
{% endblock %}", "backend/index.twig", "/home/volk/project/rnd/laravel/project/templates/backend/index.twig");
    }
}
