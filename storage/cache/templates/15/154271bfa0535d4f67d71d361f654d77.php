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

/* frontend/home.twig */
class __TwigTemplate_82f131c2c344ccc3637a8202204116b9 extends Template
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
        return "layouts/frontend/app.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->load("layouts/frontend/app.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Framework";
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
        yield "  <!-- Hero Section -->
    <section class=\"pt-32 pb-20 gradient-bg\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-4xl mx-auto text-center\">
                <span class=\"inline-block px-3 py-1 text-xs font-semibold rounded-full bg-primary-100 text-primary-700 mb-4\">v1.0.0 Beta Released</span>
                <h1 class=\"text-5xl md:text-6xl font-bold tracking-tight text-gray-900 mb-6\">
                    Build <span class=\"bg-gradient-to-r from-primary-600 to-primary-400 bg-clip-text text-transparent\">Modern PHP</span> Applications
                </h1>
                <p class=\"text-xl text-gray-600 max-w-3xl mx-auto mb-10\">
                    Axiom PHP is a high-performance framework designed for developers who demand elegance, speed, and scalability in their web applications.
                </p>
                <div class=\"flex flex-col sm:flex-row justify-center gap-4\">
                    <a href=\"#\" class=\"inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 shadow-lg transition transform hover:-translate-y-1\">
                        Get Started
                        <svg class=\"ml-2 w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M14 5l7 7m0 0l-7 7m7-7H3\"></path>
                        </svg>
                    </a>
                    <a href=\"#\" class=\"inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-white hover:bg-gray-50 shadow transition\">
                        View on GitHub
                    </a>
                </div>
            </div>
        </div>
    </section>

";
        // line 32
        yield (is_scalar($tmp = ($context["table"] ?? null)) ? new Markup($tmp, $this->env->getCharset()) : $tmp);
        yield "

    <!-- Logo Cloud -->
    <section class=\"py-12 bg-gray-50\">
        <div class=\"container mx-auto px-6\">
            <p class=\"text-center text-sm font-semibold uppercase text-gray-500 tracking-wider mb-8\">Trusted by innovative teams worldwide</p>
            <div class=\"grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center justify-center\">
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+1\" alt=\"Company 1\" class=\"h-8\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+2\" alt=\"Company 2\" class=\"h-8\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+3\" alt=\"Company 3\" class=\"h-10\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+4\" alt=\"Company 4\" class=\"h-8\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+5\" alt=\"Company 5\" class=\"h-6\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+6\" alt=\"Company 6\" class=\"h-8\">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class=\"py-20\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-3xl mx-auto text-center mb-16\">
                <h2 class=\"text-3xl font-bold text-gray-900 mb-4\">Developer Experience First</h2>
                <p class=\"text-lg text-gray-600\">Axiom PHP is built with developer productivity and happiness in mind. Every feature is designed to make your workflow smoother.</p>
            </div>
            
            <div class=\"grid md:grid-cols-3 gap-8\">
                <!-- Feature 1 -->
                <div class=\"premium-card bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition\">
                    <div class=\"w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center mb-6\">
                        <svg class=\"w-6 h-6 text-primary-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13 10V3L4 14h7v7l9-11h-7z\"></path>
                        </svg>
                    </div>
                    <h3 class=\"text-xl font-semibold text-gray-900 mb-3\">Lightning Fast</h3>
                    <p class=\"text-gray-600\">Optimized for performance with minimal overhead, Axiom ensures your applications run at peak efficiency.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class=\"premium-card bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition\">
                    <div class=\"w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center mb-6\">
                        <svg class=\"w-6 h-6 text-primary-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z\"></path>
                        </svg>
                    </div>
                    <h3 class=\"text-xl font-semibold text-gray-900 mb-3\">Modular Architecture</h3>
                    <p class=\"text-gray-600\">Built with modularity at its core, allowing you to use only what you need while keeping your application lean.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class=\"premium-card bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition\">
                    <div class=\"w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center mb-6\">
                        <svg class=\"w-6 h-6 text-primary-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4\"></path>
                        </svg>
                    </div>
                    <h3 class=\"text-xl font-semibold text-gray-900 mb-3\">Expressive Syntax</h3>
                    <p class=\"text-gray-600\">Designed with developer experience in mind, Axiom offers an elegant, expressive syntax that's easy to learn.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Example Section -->
    <section class=\"py-20 bg-gray-900\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-5xl mx-auto\">
                <div class=\"flex flex-col md:flex-row gap-12 items-center\">
                    <div class=\"md:w-1/2\">
                        <h2 class=\"text-3xl font-bold text-white mb-6\">Elegant Code, Exceptional Performance</h2>
                        <p class=\"text-lg text-gray-300 mb-8\">Axiom's intuitive API allows you to focus on what matters most - building great applications. Our carefully crafted syntax reduces boilerplate while maintaining clarity.</p>
                        <ul class=\"space-y-4\">
                            <li class=\"flex items-start\">
                                <svg class=\"flex-shrink-0 w-6 h-6 text-primary-400 mt-0.5 mr-3\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path>
                                </svg>
                                <span class=\"text-gray-300\">Intuitive routing system</span>
                            </li>
                            <li class=\"flex items-start\">
                                <svg class=\"flex-shrink-0 w-6 h-6 text-primary-400 mt-0.5 mr-3\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path>
                                </svg>
                                <span class=\"text-gray-300\">Powerful ORM with relationships</span>
                            </li>
                            <li class=\"flex items-start\">
                                <svg class=\"flex-shrink-0 w-6 h-6 text-primary-400 mt-0.5 mr-3\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path>
                                </svg>
                                <span class=\"text-gray-300\">Built-in authentication scaffolding</span>
                            </li>
                        </ul>
                    </div>
                    <div class=\"md:w-1/2\">
                        <div class=\"code-block rounded-xl overflow-hidden shadow-2xl\">
                            <div class=\"flex items-center bg-gray-800 px-4 py-3\">
                                <div class=\"flex space-x-2\">
                                    <div class=\"w-3 h-3 rounded-full bg-red-500\"></div>
                                    <div class=\"w-3 h-3 rounded-full bg-yellow-500\"></div>
                                    <div class=\"w-3 h-3 rounded-full bg-green-500\"></div>
                                </div>
                                <div class=\"text-xs text-gray-400 ml-4\">routes/web.php</div>
                            </div>
                            <pre class=\"p-6 font-mono text-sm text-gray-200 overflow-x-auto\"><code><span class=\"text-primary-400\">Route</span>::<span class=\"text-accent-400\">get</span>(<span class=\"text-green-400\">'/'</span>, <span class=\"text-purple-400\">function</span>() {
    <span class=\"text-primary-400\">return</span> <span class=\"text-primary-400\">view</span>(<span class=\"text-green-400\">'welcome'</span>); 
        });

        <span class=\"text-primary-400\">Route</span>::<span class=\"text-accent-400\">resource</span>(<span class=\"text-green-400\">'posts'</span>, <span class=\"text-green-400\">'PostController'</span>);

        <span class=\"text-gray-500\">// API routes with authentication</span>
        <span class=\"text-primary-400\">Route</span>::<span class=\"text-accent-400\">middleware</span>([<span class=\"text-green-400\">'auth:api'</span>])-><span class=\"text-accent-400\">group</span>(<span class=\"text-purple-400\">function</span>() {
            <span class=\"text-primary-400\">Route</span>::<span class=\"text-accent-400\">apiResource</span>(<span class=\"text-green-400\">'comments'</span>, <span class=\"text-green-400\">'CommentController'</span>);
        });</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Changelog Preview Section -->
    <section class=\"py-20 bg-white\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-4xl mx-auto text-center mb-16\">
                <h2 class=\"text-3xl font-bold text-gray-900 mb-4\">Latest Updates</h2>
                <p class=\"text-lg text-gray-600\">Stay informed about the newest features and improvements in Axiom PHP.</p>
            </div>
            
            <div class=\"max-w-3xl mx-auto\">
                <div class=\"border-l-4 border-primary-500 pl-6 mb-12\">
                    <div class=\"flex flex-col sm:flex-row sm:items-baseline sm:justify-between\">
                        <h3 class=\"text-2xl font-bold text-gray-900\">v2.0.0 - \"Horizon\"</h3>
                        <span class=\"text-sm font-medium text-gray-500 sm:ml-4\">Released October 15, 2023</span>
                    </div>
                    <div class=\"mt-4\">
                        <h4 class=\"font-semibold text-gray-900 mb-2\">New Features</h4>
                        <ul class=\"list-disc pl-5 space-y-1 text-gray-600\">
                            <li>Revamped database query builder with relation support</li>
                            <li>Integrated real-time event broadcasting</li>
                            <li>New task scheduling API</li>
                        </ul>
                        
                        <h4 class=\"font-semibold text-gray-900 mt-6 mb-2\">Improvements</h4>
                        <ul class=\"list-disc pl-5 space-y-1 text-gray-600\">
                            <li>30% faster routing performance</li>
                            <li>Reduced memory usage by 15%</li>
                        </ul>
                    </div>
                </div>
                
                <div class=\"text-center\">
                    <a href=\"#\" class=\"inline-flex items-center text-primary-600 font-medium hover:text-primary-500\">
                        View full changelog
                        <svg class=\"ml-1 w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5l7 7-7 7\"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class=\"py-20 bg-primary-700\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-4xl mx-auto text-center\">
                <h2 class=\"text-3xl font-bold text-white mb-6\">Ready to Build Something Amazing?</h2>
                <p class=\"text-xl text-primary-100 mb-10\">Join thousands of developers who have already accelerated their PHP development with Axiom.</p>
                <div class=\"flex flex-col sm:flex-row justify-center gap-4\">
                    <a href=\"#\" class=\"inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-white hover:bg-gray-50 shadow-lg transition transform hover:-translate-y-1\">
                        Get Started
                    </a>
                    <a href=\"#\" class=\"inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500 shadow transition\">
                        Documentation
                    </a>
                </div>
            </div>
        </div>
    </section>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "frontend/home.twig";
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
        return array (  98 => 32,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"layouts/frontend/app.twig\" %}

{% block title %}Framework{% endblock %}

{% block body %}
  <!-- Hero Section -->
    <section class=\"pt-32 pb-20 gradient-bg\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-4xl mx-auto text-center\">
                <span class=\"inline-block px-3 py-1 text-xs font-semibold rounded-full bg-primary-100 text-primary-700 mb-4\">v1.0.0 Beta Released</span>
                <h1 class=\"text-5xl md:text-6xl font-bold tracking-tight text-gray-900 mb-6\">
                    Build <span class=\"bg-gradient-to-r from-primary-600 to-primary-400 bg-clip-text text-transparent\">Modern PHP</span> Applications
                </h1>
                <p class=\"text-xl text-gray-600 max-w-3xl mx-auto mb-10\">
                    Axiom PHP is a high-performance framework designed for developers who demand elegance, speed, and scalability in their web applications.
                </p>
                <div class=\"flex flex-col sm:flex-row justify-center gap-4\">
                    <a href=\"#\" class=\"inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 shadow-lg transition transform hover:-translate-y-1\">
                        Get Started
                        <svg class=\"ml-2 w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M14 5l7 7m0 0l-7 7m7-7H3\"></path>
                        </svg>
                    </a>
                    <a href=\"#\" class=\"inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-white hover:bg-gray-50 shadow transition\">
                        View on GitHub
                    </a>
                </div>
            </div>
        </div>
    </section>

{{table|raw}}

    <!-- Logo Cloud -->
    <section class=\"py-12 bg-gray-50\">
        <div class=\"container mx-auto px-6\">
            <p class=\"text-center text-sm font-semibold uppercase text-gray-500 tracking-wider mb-8\">Trusted by innovative teams worldwide</p>
            <div class=\"grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center justify-center\">
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+1\" alt=\"Company 1\" class=\"h-8\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+2\" alt=\"Company 2\" class=\"h-8\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+3\" alt=\"Company 3\" class=\"h-10\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+4\" alt=\"Company 4\" class=\"h-8\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+5\" alt=\"Company 5\" class=\"h-6\">
                </div>
                <div class=\"flex justify-center opacity-60 hover:opacity-100 transition\">
                    <img src=\"https://via.placeholder.com/120x40?text=Company+6\" alt=\"Company 6\" class=\"h-8\">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class=\"py-20\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-3xl mx-auto text-center mb-16\">
                <h2 class=\"text-3xl font-bold text-gray-900 mb-4\">Developer Experience First</h2>
                <p class=\"text-lg text-gray-600\">Axiom PHP is built with developer productivity and happiness in mind. Every feature is designed to make your workflow smoother.</p>
            </div>
            
            <div class=\"grid md:grid-cols-3 gap-8\">
                <!-- Feature 1 -->
                <div class=\"premium-card bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition\">
                    <div class=\"w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center mb-6\">
                        <svg class=\"w-6 h-6 text-primary-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13 10V3L4 14h7v7l9-11h-7z\"></path>
                        </svg>
                    </div>
                    <h3 class=\"text-xl font-semibold text-gray-900 mb-3\">Lightning Fast</h3>
                    <p class=\"text-gray-600\">Optimized for performance with minimal overhead, Axiom ensures your applications run at peak efficiency.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class=\"premium-card bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition\">
                    <div class=\"w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center mb-6\">
                        <svg class=\"w-6 h-6 text-primary-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z\"></path>
                        </svg>
                    </div>
                    <h3 class=\"text-xl font-semibold text-gray-900 mb-3\">Modular Architecture</h3>
                    <p class=\"text-gray-600\">Built with modularity at its core, allowing you to use only what you need while keeping your application lean.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class=\"premium-card bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition\">
                    <div class=\"w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center mb-6\">
                        <svg class=\"w-6 h-6 text-primary-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4\"></path>
                        </svg>
                    </div>
                    <h3 class=\"text-xl font-semibold text-gray-900 mb-3\">Expressive Syntax</h3>
                    <p class=\"text-gray-600\">Designed with developer experience in mind, Axiom offers an elegant, expressive syntax that's easy to learn.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Example Section -->
    <section class=\"py-20 bg-gray-900\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-5xl mx-auto\">
                <div class=\"flex flex-col md:flex-row gap-12 items-center\">
                    <div class=\"md:w-1/2\">
                        <h2 class=\"text-3xl font-bold text-white mb-6\">Elegant Code, Exceptional Performance</h2>
                        <p class=\"text-lg text-gray-300 mb-8\">Axiom's intuitive API allows you to focus on what matters most - building great applications. Our carefully crafted syntax reduces boilerplate while maintaining clarity.</p>
                        <ul class=\"space-y-4\">
                            <li class=\"flex items-start\">
                                <svg class=\"flex-shrink-0 w-6 h-6 text-primary-400 mt-0.5 mr-3\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path>
                                </svg>
                                <span class=\"text-gray-300\">Intuitive routing system</span>
                            </li>
                            <li class=\"flex items-start\">
                                <svg class=\"flex-shrink-0 w-6 h-6 text-primary-400 mt-0.5 mr-3\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path>
                                </svg>
                                <span class=\"text-gray-300\">Powerful ORM with relationships</span>
                            </li>
                            <li class=\"flex items-start\">
                                <svg class=\"flex-shrink-0 w-6 h-6 text-primary-400 mt-0.5 mr-3\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path>
                                </svg>
                                <span class=\"text-gray-300\">Built-in authentication scaffolding</span>
                            </li>
                        </ul>
                    </div>
                    <div class=\"md:w-1/2\">
                        <div class=\"code-block rounded-xl overflow-hidden shadow-2xl\">
                            <div class=\"flex items-center bg-gray-800 px-4 py-3\">
                                <div class=\"flex space-x-2\">
                                    <div class=\"w-3 h-3 rounded-full bg-red-500\"></div>
                                    <div class=\"w-3 h-3 rounded-full bg-yellow-500\"></div>
                                    <div class=\"w-3 h-3 rounded-full bg-green-500\"></div>
                                </div>
                                <div class=\"text-xs text-gray-400 ml-4\">routes/web.php</div>
                            </div>
                            <pre class=\"p-6 font-mono text-sm text-gray-200 overflow-x-auto\"><code><span class=\"text-primary-400\">Route</span>::<span class=\"text-accent-400\">get</span>(<span class=\"text-green-400\">'/'</span>, <span class=\"text-purple-400\">function</span>() {
    <span class=\"text-primary-400\">return</span> <span class=\"text-primary-400\">view</span>(<span class=\"text-green-400\">'welcome'</span>); 
        });

        <span class=\"text-primary-400\">Route</span>::<span class=\"text-accent-400\">resource</span>(<span class=\"text-green-400\">'posts'</span>, <span class=\"text-green-400\">'PostController'</span>);

        <span class=\"text-gray-500\">// API routes with authentication</span>
        <span class=\"text-primary-400\">Route</span>::<span class=\"text-accent-400\">middleware</span>([<span class=\"text-green-400\">'auth:api'</span>])-><span class=\"text-accent-400\">group</span>(<span class=\"text-purple-400\">function</span>() {
            <span class=\"text-primary-400\">Route</span>::<span class=\"text-accent-400\">apiResource</span>(<span class=\"text-green-400\">'comments'</span>, <span class=\"text-green-400\">'CommentController'</span>);
        });</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Changelog Preview Section -->
    <section class=\"py-20 bg-white\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-4xl mx-auto text-center mb-16\">
                <h2 class=\"text-3xl font-bold text-gray-900 mb-4\">Latest Updates</h2>
                <p class=\"text-lg text-gray-600\">Stay informed about the newest features and improvements in Axiom PHP.</p>
            </div>
            
            <div class=\"max-w-3xl mx-auto\">
                <div class=\"border-l-4 border-primary-500 pl-6 mb-12\">
                    <div class=\"flex flex-col sm:flex-row sm:items-baseline sm:justify-between\">
                        <h3 class=\"text-2xl font-bold text-gray-900\">v2.0.0 - \"Horizon\"</h3>
                        <span class=\"text-sm font-medium text-gray-500 sm:ml-4\">Released October 15, 2023</span>
                    </div>
                    <div class=\"mt-4\">
                        <h4 class=\"font-semibold text-gray-900 mb-2\">New Features</h4>
                        <ul class=\"list-disc pl-5 space-y-1 text-gray-600\">
                            <li>Revamped database query builder with relation support</li>
                            <li>Integrated real-time event broadcasting</li>
                            <li>New task scheduling API</li>
                        </ul>
                        
                        <h4 class=\"font-semibold text-gray-900 mt-6 mb-2\">Improvements</h4>
                        <ul class=\"list-disc pl-5 space-y-1 text-gray-600\">
                            <li>30% faster routing performance</li>
                            <li>Reduced memory usage by 15%</li>
                        </ul>
                    </div>
                </div>
                
                <div class=\"text-center\">
                    <a href=\"#\" class=\"inline-flex items-center text-primary-600 font-medium hover:text-primary-500\">
                        View full changelog
                        <svg class=\"ml-1 w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5l7 7-7 7\"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class=\"py-20 bg-primary-700\">
        <div class=\"container mx-auto px-6\">
            <div class=\"max-w-4xl mx-auto text-center\">
                <h2 class=\"text-3xl font-bold text-white mb-6\">Ready to Build Something Amazing?</h2>
                <p class=\"text-xl text-primary-100 mb-10\">Join thousands of developers who have already accelerated their PHP development with Axiom.</p>
                <div class=\"flex flex-col sm:flex-row justify-center gap-4\">
                    <a href=\"#\" class=\"inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-white hover:bg-gray-50 shadow-lg transition transform hover:-translate-y-1\">
                        Get Started
                    </a>
                    <a href=\"#\" class=\"inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500 shadow transition\">
                        Documentation
                    </a>
                </div>
            </div>
        </div>
    </section>
{% endblock %}
    
  ", "frontend/home.twig", "/home/volk/project/rnd/laravel/project/templates/frontend/home.twig");
    }
}
