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
            <!-- Table Filters -->
            <div class=\"px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4\">
                <div class=\"relative w-full sm:w-64\">
                    <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                        <i class=\"fas fa-search text-gray-400\"></i>
                    </div>
                    <input 
                        type=\"text\" 
                        class=\"pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full\" 
                        placeholder=\"Search users...\"
                    >
                </div>
                <div class=\"flex items-center gap-3 w-full sm:w-auto\">
                    <div class=\"relative w-full sm:w-48\">
                        <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full\">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                            <option>Pending</option>
                        </select>
                        <div class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                            <i class=\"fas fa-chevron-down text-gray-400\"></i>
                        </div>
                    </div>
                    <button class=\"p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                        <i class=\"fas fa-sync-alt text-gray-500\"></i>
                    </button>
                </div>
            </div>

            <!-- Static Table (Replace with ";
        // line 57
        yield (is_scalar($tmp = ($context["table"] ?? null)) ? new Markup($tmp, $this->env->getCharset()) : $tmp);
        yield " when dynamic) -->
            <div class=\"overflow-x-auto\">
                <table class=\"min-w-full divide-y divide-gray-200\">
                    <thead class=\"bg-gray-50\">
                        <tr>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10\">
                                <input type=\"checkbox\" class=\"rounded border-gray-300 text-blue-600 focus:ring-blue-500\">
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Name
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Email
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Role
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Status
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class=\"bg-white divide-y divide-gray-200\">
                        <!-- User 1 -->
                        <tr class=\"hover:bg-gray-50\">
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <input type=\"checkbox\" class=\"rounded border-gray-300 text-blue-600 focus:ring-blue-500\">
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"flex items-center\">
                                    <div class=\"flex-shrink-0 h-10 w-10\">
                                        <img class=\"h-10 w-10 rounded-full\" src=\"https://i.pravatar.cc/150?img=1\" alt=\"\">
                                    </div>
                                    <div class=\"ml-4\">
                                        <div class=\"text-sm font-medium text-gray-900\">John Doe</div>
                                        <div class=\"text-sm text-gray-500\">@johndoe</div>
                                    </div>
                                </div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">john.doe@example.com</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">Administrator</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <span class=\"px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800\">
                                    Active
                                </span>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap text-right text-sm font-medium\">
                                <div class=\"flex justify-end space-x-2\">
                                    <a href=\"#\" class=\"text-blue-600 hover:text-blue-900\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-indigo-600 hover:text-indigo-900\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-red-600 hover:text-red-900\">
                                        <i class=\"fas fa-trash\"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- User 2 -->
                        <tr class=\"hover:bg-gray-50\">
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <input type=\"checkbox\" class=\"rounded border-gray-300 text-blue-600 focus:ring-blue-500\">
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"flex items-center\">
                                    <div class=\"flex-shrink-0 h-10 w-10\">
                                        <img class=\"h-10 w-10 rounded-full\" src=\"https://i.pravatar.cc/150?img=2\" alt=\"\">
                                    </div>
                                    <div class=\"ml-4\">
                                        <div class=\"text-sm font-medium text-gray-900\">Jane Smith</div>
                                        <div class=\"text-sm text-gray-500\">@janesmith</div>
                                    </div>
                                </div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">jane.smith@example.com</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">Editor</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <span class=\"px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800\">
                                    Active
                                </span>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap text-right text-sm font-medium\">
                                <div class=\"flex justify-end space-x-2\">
                                    <a href=\"#\" class=\"text-blue-600 hover:text-blue-900\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-indigo-600 hover:text-indigo-900\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-red-600 hover:text-red-900\">
                                        <i class=\"fas fa-trash\"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- User 3 -->
                        <tr class=\"hover:bg-gray-50\">
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <input type=\"checkbox\" class=\"rounded border-gray-300 text-blue-600 focus:ring-blue-500\">
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"flex items-center\">
                                    <div class=\"flex-shrink-0 h-10 w-10\">
                                        <img class=\"h-10 w-10 rounded-full\" src=\"https://i.pravatar.cc/150?img=3\" alt=\"\">
                                    </div>
                                    <div class=\"ml-4\">
                                        <div class=\"text-sm font-medium text-gray-900\">Robert Johnson</div>
                                        <div class=\"text-sm text-gray-500\">@robertj</div>
                                    </div>
                                </div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">robert.j@example.com</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">Contributor</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <span class=\"px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800\">
                                    Pending
                                </span>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap text-right text-sm font-medium\">
                                <div class=\"flex justify-end space-x-2\">
                                    <a href=\"#\" class=\"text-blue-600 hover:text-blue-900\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-indigo-600 hover:text-indigo-900\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-red-600 hover:text-red-900\">
                                        <i class=\"fas fa-trash\"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class=\"px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4\">
                <div class=\"text-sm text-gray-600\">
                    Showing <span class=\"font-medium\">1</span> to <span class=\"font-medium\">3</span> of <span class=\"font-medium\">24</span> results
                </div>
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
        return array (  123 => 57,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"layouts/backend/app.twig\" %}

{% block title %}User Management{% endblock %}

{% block body %}
    <div class=\"container mx-auto px-4 py-6\">
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
            <!-- Table Filters -->
            <div class=\"px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4\">
                <div class=\"relative w-full sm:w-64\">
                    <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                        <i class=\"fas fa-search text-gray-400\"></i>
                    </div>
                    <input 
                        type=\"text\" 
                        class=\"pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full\" 
                        placeholder=\"Search users...\"
                    >
                </div>
                <div class=\"flex items-center gap-3 w-full sm:w-auto\">
                    <div class=\"relative w-full sm:w-48\">
                        <select class=\"appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-full\">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                            <option>Pending</option>
                        </select>
                        <div class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                            <i class=\"fas fa-chevron-down text-gray-400\"></i>
                        </div>
                    </div>
                    <button class=\"p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors\">
                        <i class=\"fas fa-sync-alt text-gray-500\"></i>
                    </button>
                </div>
            </div>

            <!-- Static Table (Replace with {{ table | raw }} when dynamic) -->
            <div class=\"overflow-x-auto\">
                <table class=\"min-w-full divide-y divide-gray-200\">
                    <thead class=\"bg-gray-50\">
                        <tr>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10\">
                                <input type=\"checkbox\" class=\"rounded border-gray-300 text-blue-600 focus:ring-blue-500\">
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Name
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Email
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Role
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Status
                            </th>
                            <th scope=\"col\" class=\"px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider\">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class=\"bg-white divide-y divide-gray-200\">
                        <!-- User 1 -->
                        <tr class=\"hover:bg-gray-50\">
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <input type=\"checkbox\" class=\"rounded border-gray-300 text-blue-600 focus:ring-blue-500\">
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"flex items-center\">
                                    <div class=\"flex-shrink-0 h-10 w-10\">
                                        <img class=\"h-10 w-10 rounded-full\" src=\"https://i.pravatar.cc/150?img=1\" alt=\"\">
                                    </div>
                                    <div class=\"ml-4\">
                                        <div class=\"text-sm font-medium text-gray-900\">John Doe</div>
                                        <div class=\"text-sm text-gray-500\">@johndoe</div>
                                    </div>
                                </div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">john.doe@example.com</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">Administrator</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <span class=\"px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800\">
                                    Active
                                </span>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap text-right text-sm font-medium\">
                                <div class=\"flex justify-end space-x-2\">
                                    <a href=\"#\" class=\"text-blue-600 hover:text-blue-900\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-indigo-600 hover:text-indigo-900\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-red-600 hover:text-red-900\">
                                        <i class=\"fas fa-trash\"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- User 2 -->
                        <tr class=\"hover:bg-gray-50\">
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <input type=\"checkbox\" class=\"rounded border-gray-300 text-blue-600 focus:ring-blue-500\">
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"flex items-center\">
                                    <div class=\"flex-shrink-0 h-10 w-10\">
                                        <img class=\"h-10 w-10 rounded-full\" src=\"https://i.pravatar.cc/150?img=2\" alt=\"\">
                                    </div>
                                    <div class=\"ml-4\">
                                        <div class=\"text-sm font-medium text-gray-900\">Jane Smith</div>
                                        <div class=\"text-sm text-gray-500\">@janesmith</div>
                                    </div>
                                </div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">jane.smith@example.com</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">Editor</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <span class=\"px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800\">
                                    Active
                                </span>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap text-right text-sm font-medium\">
                                <div class=\"flex justify-end space-x-2\">
                                    <a href=\"#\" class=\"text-blue-600 hover:text-blue-900\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-indigo-600 hover:text-indigo-900\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-red-600 hover:text-red-900\">
                                        <i class=\"fas fa-trash\"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- User 3 -->
                        <tr class=\"hover:bg-gray-50\">
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <input type=\"checkbox\" class=\"rounded border-gray-300 text-blue-600 focus:ring-blue-500\">
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"flex items-center\">
                                    <div class=\"flex-shrink-0 h-10 w-10\">
                                        <img class=\"h-10 w-10 rounded-full\" src=\"https://i.pravatar.cc/150?img=3\" alt=\"\">
                                    </div>
                                    <div class=\"ml-4\">
                                        <div class=\"text-sm font-medium text-gray-900\">Robert Johnson</div>
                                        <div class=\"text-sm text-gray-500\">@robertj</div>
                                    </div>
                                </div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">robert.j@example.com</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <div class=\"text-sm text-gray-900\">Contributor</div>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap\">
                                <span class=\"px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800\">
                                    Pending
                                </span>
                            </td>
                            <td class=\"px-6 py-4 whitespace-nowrap text-right text-sm font-medium\">
                                <div class=\"flex justify-end space-x-2\">
                                    <a href=\"#\" class=\"text-blue-600 hover:text-blue-900\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-indigo-600 hover:text-indigo-900\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <a href=\"#\" class=\"text-red-600 hover:text-red-900\">
                                        <i class=\"fas fa-trash\"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class=\"px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4\">
                <div class=\"text-sm text-gray-600\">
                    Showing <span class=\"font-medium\">1</span> to <span class=\"font-medium\">3</span> of <span class=\"font-medium\">24</span> results
                </div>
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
