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

/* backend/intruduction.twig */
class __TwigTemplate_336761b43018f53f8b8a316fad79d2d0 extends Template
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
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 4
        yield "
    <!-- Welcome Section -->
    <div class=\"bg-white rounded-xl shadow-sm p-8 mb-8 text-center\">
        <div class=\"max-w-3xl mx-auto\">
            <div class=\"w-20 h-20 mx-auto mb-6 rounded-xl bg-primary-50 flex items-center justify-center\">
                <svg class=\"w-10 h-10 text-primary-600\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                    <path d=\"M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\"></path>
                </svg>
            </div>
            <h1 class=\"text-3xl md:text-4xl font-bold text-gray-900 mb-4\">
                Welcome to <span class=\"axiom-gradient-text\">Axiom PHP</span>
            </h1>
            <p class=\"text-lg text-gray-600 mb-6\">
                The premium PHP framework for building modern, high-performance web applications.
            </p>
            <div class=\"flex flex-wrap justify-center gap-3\">
                <a href=\"#\" class=\"px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition\">
                    <i class=\"fas fa-book mr-2\"></i> Documentation
                </a>
                <a href=\"#\" class=\"px-5 py-2 bg-white border border-gray-200 hover:border-gray-300 text-gray-700 rounded-lg font-medium transition\">
                    <i class=\"fas fa-video mr-2\"></i> Video Tutorials
                </a>
                <a href=\"#\" class=\"px-5 py-2 bg-white border border-gray-200 hover:border-gray-300 text-gray-700 rounded-lg font-medium transition\">
                    <i class=\"fas fa-code mr-2\"></i> API Reference
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8\">
        <a href=\"#\" class=\"quick-link-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-primary-100 transition duration-300\">
            <div class=\"flex items-center mb-4\">
                <div class=\"w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center mr-4\">
                    <i class=\"fas fa-book text-green-500 text-lg\"></i>
                </div>
                <h3 class=\"text-lg font-semibold text-gray-800\">Documentation</h3>
            </div>
            <p class=\"text-gray-500 text-sm\">Explore the comprehensive guides and API references</p>
        </a>

        <a href=\"#\" class=\"quick-link-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-primary-100 transition duration-300\">
            <div class=\"flex items-center mb-4\">
                <div class=\"w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center mr-4\">
                    <i class=\"fas fa-box text-blue-500 text-lg\"></i>
                </div>
                <h3 class=\"text-lg font-semibold text-gray-800\">Packages</h3>
            </div>
            <p class=\"text-gray-500 text-sm\">Browse and install official Axiom packages</p>
        </a>

        <a href=\"#\" class=\"quick-link-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-primary-100 transition duration-300\">
            <div class=\"flex items-center mb-4\">
                <div class=\"w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center mr-4\">
                    <i class=\"fas fa-users text-purple-500 text-lg\"></i>
                </div>
                <h3 class=\"text-lg font-semibold text-gray-800\">Community</h3>
            </div>
            <p class=\"text-gray-500 text-sm\">Join our growing developer community</p>
        </a>

        <a href=\"#\" class=\"quick-link-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-primary-100 transition duration-300\">
            <div class=\"flex items-center mb-4\">
                <div class=\"w-12 h-12 rounded-lg bg-orange-50 flex items-center justify-center mr-4\">
                    <i class=\"fas fa-tools text-orange-500 text-lg\"></i>
                </div>
                <h3 class=\"text-lg font-semibold text-gray-800\">Tools</h3>
            </div>
            <p class=\"text-gray-500 text-sm\">Developer tools and integrations</p>
        </a>
    </div>

";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "backend/intruduction.twig";
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
        return array (  58 => 4,  51 => 3,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"layouts/backend/app.twig\" %}

{% block body %}

    <!-- Welcome Section -->
    <div class=\"bg-white rounded-xl shadow-sm p-8 mb-8 text-center\">
        <div class=\"max-w-3xl mx-auto\">
            <div class=\"w-20 h-20 mx-auto mb-6 rounded-xl bg-primary-50 flex items-center justify-center\">
                <svg class=\"w-10 h-10 text-primary-600\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                    <path d=\"M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\"></path>
                </svg>
            </div>
            <h1 class=\"text-3xl md:text-4xl font-bold text-gray-900 mb-4\">
                Welcome to <span class=\"axiom-gradient-text\">Axiom PHP</span>
            </h1>
            <p class=\"text-lg text-gray-600 mb-6\">
                The premium PHP framework for building modern, high-performance web applications.
            </p>
            <div class=\"flex flex-wrap justify-center gap-3\">
                <a href=\"#\" class=\"px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition\">
                    <i class=\"fas fa-book mr-2\"></i> Documentation
                </a>
                <a href=\"#\" class=\"px-5 py-2 bg-white border border-gray-200 hover:border-gray-300 text-gray-700 rounded-lg font-medium transition\">
                    <i class=\"fas fa-video mr-2\"></i> Video Tutorials
                </a>
                <a href=\"#\" class=\"px-5 py-2 bg-white border border-gray-200 hover:border-gray-300 text-gray-700 rounded-lg font-medium transition\">
                    <i class=\"fas fa-code mr-2\"></i> API Reference
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8\">
        <a href=\"#\" class=\"quick-link-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-primary-100 transition duration-300\">
            <div class=\"flex items-center mb-4\">
                <div class=\"w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center mr-4\">
                    <i class=\"fas fa-book text-green-500 text-lg\"></i>
                </div>
                <h3 class=\"text-lg font-semibold text-gray-800\">Documentation</h3>
            </div>
            <p class=\"text-gray-500 text-sm\">Explore the comprehensive guides and API references</p>
        </a>

        <a href=\"#\" class=\"quick-link-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-primary-100 transition duration-300\">
            <div class=\"flex items-center mb-4\">
                <div class=\"w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center mr-4\">
                    <i class=\"fas fa-box text-blue-500 text-lg\"></i>
                </div>
                <h3 class=\"text-lg font-semibold text-gray-800\">Packages</h3>
            </div>
            <p class=\"text-gray-500 text-sm\">Browse and install official Axiom packages</p>
        </a>

        <a href=\"#\" class=\"quick-link-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-primary-100 transition duration-300\">
            <div class=\"flex items-center mb-4\">
                <div class=\"w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center mr-4\">
                    <i class=\"fas fa-users text-purple-500 text-lg\"></i>
                </div>
                <h3 class=\"text-lg font-semibold text-gray-800\">Community</h3>
            </div>
            <p class=\"text-gray-500 text-sm\">Join our growing developer community</p>
        </a>

        <a href=\"#\" class=\"quick-link-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-primary-100 transition duration-300\">
            <div class=\"flex items-center mb-4\">
                <div class=\"w-12 h-12 rounded-lg bg-orange-50 flex items-center justify-center mr-4\">
                    <i class=\"fas fa-tools text-orange-500 text-lg\"></i>
                </div>
                <h3 class=\"text-lg font-semibold text-gray-800\">Tools</h3>
            </div>
            <p class=\"text-gray-500 text-sm\">Developer tools and integrations</p>
        </a>
    </div>

{% endblock %}          
          ", "backend/intruduction.twig", "/home/volk/project/rnd/laravel/project/templates/backend/intruduction.twig");
    }
}
