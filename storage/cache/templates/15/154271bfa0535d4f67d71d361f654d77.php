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

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 2
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield " - Home</title>
    
    ";
        // line 9
        yield (is_scalar($tmp = $this->env->getFunction('vite')->getCallable()(["project/templates/assets/css/app.css", "project/templates/assets/js/app.js"])) ? new Markup($tmp, $this->env->getCharset()) : $tmp);
        yield "

</head>
<body class=\"font-sans antialiased text-gray-800\">
    ";
        // line 14
        yield "    <nav class=\"bg-white shadow-sm\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">
            <div class=\"flex justify-between h-16\">
                <div class=\"flex items-center\">
                    <a href=\"/\" class=\"flex items-center\">
                        <span class=\"text-xl font-bold text-blue-600\">";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</span>
                    </a>
                </div>
                <div class=\"hidden sm:ml-6 sm:flex sm:items-center space-x-8\">
                    <a href=\"/\" class=\"text-blue-600 font-medium\">Home</a>
                    <a href=\"/features\" class=\"hover:text-blue-600\">Features</a>
                    <a href=\"/pricing\" class=\"hover:text-blue-600\">Pricing</a>
                    <a href=\"/contact\" class=\"hover:text-blue-600\">Contact</a>
                    
                    ";
        // line 28
        if ((($tmp = ($context["is_authenticated"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 29
            yield "                        <a href=\"/dashboard\" class=\"bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700\">
                            Dashboard
                        </a>
                    ";
        } else {
            // line 33
            yield "                        <a href=\"/login\" class=\"text-blue-600\">Login</a>
                        <a href=\"/register\" class=\"bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700\">
                            Register
                        </a>
                    ";
        }
        // line 38
        yield "                </div>
            </div>
        </div>
    </nav>

    ";
        // line 44
        yield "    <section class=\"hero-gradient text-white py-20\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center\">
            <h1 class=\"text-4xl md:text-5xl font-bold mb-6\">Build Amazing Applications</h1>
            <p class=\"text-xl max-w-3xl mx-auto mb-8\">
                ";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield " provides elegant tools to build modern web applications with PHP.
            </p>
            <div class=\"space-x-4\">
                <a href=\"/docs\" class=\"bg-white text-blue-600 px-6 py-3 rounded-md font-medium hover:bg-gray-100\">
                    Documentation
                </a>
                <a href=\"https://github.com/your-repo\" class=\"bg-transparent border-2 border-white px-6 py-3 rounded-md font-medium hover:bg-white hover:text-blue-600\">
                    GitHub
                </a>
            </div>
        </div>
    </section>

    ";
        // line 62
        yield "    <section class=\"py-16 bg-gray-50\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">
            <div class=\"text-center mb-12\">
                <h2 class=\"text-3xl font-bold mb-4\">Powerful Features</h2>
                <p class=\"max-w-2xl mx-auto text-gray-600\">
                    Everything you need to build modern web applications
                </p>
            </div>
            
            <div class=\"grid md:grid-cols-3 gap-8\">
                ";
        // line 72
        $_v0 = new \Twig\Runtime\LoopIterator(($context["features"] ?? null));
        yield from ($_v1 = function ($iterator, &$context, $blocks, $recurseFunc, $depth) {
            $macros = $this->macros;
            $parent = $context;
            foreach ($iterator as $context["_key"] => $context["feature"]) {
                // line 73
                yield "                <div class=\"feature-card bg-white p-8 rounded-lg shadow-md transition-all duration-300\">
                    <div class=\"text-blue-600 mb-4\">
                        ";
                // line 75
                yield (is_scalar($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["feature"], "icon", arguments: [], lineno: 75)) ? new Markup($tmp, $this->env->getCharset()) : $tmp);
                yield "
                    </div>
                    <h3 class=\"text-xl font-bold mb-3\">";
                // line 77
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["feature"], "title", arguments: [], lineno: 77), "html", null, true);
                yield "</h3>
                    <p class=\"text-gray-600\">";
                // line 78
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["feature"], "description", arguments: [], lineno: 78), "html", null, true);
                yield "</p>
                </div>
                ";
            }
            unset($context['_key'], $context['feature']);
            $context = array_intersect_key($context, $parent) + $parent;
            yield from [];
        })($_v0, $context, $blocks, $_v1, 0);
        // line 81
        yield "            </div>
        </div>
    </section>

    ";
        // line 86
        yield "    <section class=\"py-16 bg-white\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center\">
            <h2 class=\"text-3xl font-bold mb-6\">Ready to get started?</h2>
            <p class=\"max-w-3xl mx-auto mb-8 text-gray-600\">
                Join thousands of developers building with ";
        // line 90
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield " today.
            </p>
            <a href=\"/register\" class=\"bg-blue-600 text-white px-8 py-4 rounded-md font-medium hover:bg-blue-700 text-lg\">
                Get Started for Free
            </a>
        </div>
    </section>

    ";
        // line 99
        yield "    <footer class=\"bg-gray-800 text-white py-12\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">
            <div class=\"grid md:grid-cols-4 gap-8\">
                <div>
                    <h3 class=\"text-lg font-bold mb-4\">";
        // line 103
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</h3>
                    <p class=\"text-gray-400\">The PHP framework for web artisans.</p>
                </div>
                <div>
                    <h4 class=\"font-bold mb-4\">Resources</h4>
                    <ul class=\"space-y-2\">
                        <li><a href=\"/docs\" class=\"text-gray-400 hover:text-white\">Documentation</a></li>
                        <li><a href=\"/api\" class=\"text-gray-400 hover:text-white\">API Reference</a></li>
                        <li><a href=\"https://github.com/your-repo\" class=\"text-gray-400 hover:text-white\">GitHub</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class=\"font-bold mb-4\">Company</h4>
                    <ul class=\"space-y-2\">
                        <li><a href=\"/about\" class=\"text-gray-400 hover:text-white\">About Us</a></li>
                        <li><a href=\"/blog\" class=\"text-gray-400 hover:text-white\">Blog</a></li>
                        <li><a href=\"/careers\" class=\"text-gray-400 hover:text-white\">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class=\"font-bold mb-4\">Legal</h4>
                    <ul class=\"space-y-2\">
                        <li><a href=\"/privacy\" class=\"text-gray-400 hover:text-white\">Privacy Policy</a></li>
                        <li><a href=\"/terms\" class=\"text-gray-400 hover:text-white\">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"border-t border-gray-700 mt-12 pt-8 text-center text-gray-400\">
                <p>&copy; ";
        // line 131
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield ". All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>";
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
        return array (  225 => 131,  194 => 103,  188 => 99,  177 => 90,  171 => 86,  165 => 81,  155 => 78,  151 => 77,  146 => 75,  142 => 73,  136 => 72,  124 => 62,  108 => 48,  102 => 44,  95 => 38,  88 => 33,  82 => 29,  80 => 28,  68 => 19,  61 => 14,  54 => 9,  49 => 7,  42 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# templates/home/index.twig #}
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{{ app_name }} - Home</title>
    
    {{vite(['project/templates/assets/css/app.css','project/templates/assets/js/app.js'])|raw}}

</head>
<body class=\"font-sans antialiased text-gray-800\">
    {# Navigation #}
    <nav class=\"bg-white shadow-sm\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">
            <div class=\"flex justify-between h-16\">
                <div class=\"flex items-center\">
                    <a href=\"/\" class=\"flex items-center\">
                        <span class=\"text-xl font-bold text-blue-600\">{{ app_name }}</span>
                    </a>
                </div>
                <div class=\"hidden sm:ml-6 sm:flex sm:items-center space-x-8\">
                    <a href=\"/\" class=\"text-blue-600 font-medium\">Home</a>
                    <a href=\"/features\" class=\"hover:text-blue-600\">Features</a>
                    <a href=\"/pricing\" class=\"hover:text-blue-600\">Pricing</a>
                    <a href=\"/contact\" class=\"hover:text-blue-600\">Contact</a>
                    
                    {% if is_authenticated %}
                        <a href=\"/dashboard\" class=\"bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700\">
                            Dashboard
                        </a>
                    {% else %}
                        <a href=\"/login\" class=\"text-blue-600\">Login</a>
                        <a href=\"/register\" class=\"bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700\">
                            Register
                        </a>
                    {% endif %}
                </div>
            </div>
        </div>
    </nav>

    {# Hero Section #}
    <section class=\"hero-gradient text-white py-20\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center\">
            <h1 class=\"text-4xl md:text-5xl font-bold mb-6\">Build Amazing Applications</h1>
            <p class=\"text-xl max-w-3xl mx-auto mb-8\">
                {{ app_name }} provides elegant tools to build modern web applications with PHP.
            </p>
            <div class=\"space-x-4\">
                <a href=\"/docs\" class=\"bg-white text-blue-600 px-6 py-3 rounded-md font-medium hover:bg-gray-100\">
                    Documentation
                </a>
                <a href=\"https://github.com/your-repo\" class=\"bg-transparent border-2 border-white px-6 py-3 rounded-md font-medium hover:bg-white hover:text-blue-600\">
                    GitHub
                </a>
            </div>
        </div>
    </section>

    {# Features Section #}
    <section class=\"py-16 bg-gray-50\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">
            <div class=\"text-center mb-12\">
                <h2 class=\"text-3xl font-bold mb-4\">Powerful Features</h2>
                <p class=\"max-w-2xl mx-auto text-gray-600\">
                    Everything you need to build modern web applications
                </p>
            </div>
            
            <div class=\"grid md:grid-cols-3 gap-8\">
                {% for feature in features %}
                <div class=\"feature-card bg-white p-8 rounded-lg shadow-md transition-all duration-300\">
                    <div class=\"text-blue-600 mb-4\">
                        {{ feature.icon|raw }}
                    </div>
                    <h3 class=\"text-xl font-bold mb-3\">{{ feature.title }}</h3>
                    <p class=\"text-gray-600\">{{ feature.description }}</p>
                </div>
                {% endfor %}
            </div>
        </div>
    </section>

    {# CTA Section #}
    <section class=\"py-16 bg-white\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center\">
            <h2 class=\"text-3xl font-bold mb-6\">Ready to get started?</h2>
            <p class=\"max-w-3xl mx-auto mb-8 text-gray-600\">
                Join thousands of developers building with {{ app_name }} today.
            </p>
            <a href=\"/register\" class=\"bg-blue-600 text-white px-8 py-4 rounded-md font-medium hover:bg-blue-700 text-lg\">
                Get Started for Free
            </a>
        </div>
    </section>

    {# Footer #}
    <footer class=\"bg-gray-800 text-white py-12\">
        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">
            <div class=\"grid md:grid-cols-4 gap-8\">
                <div>
                    <h3 class=\"text-lg font-bold mb-4\">{{ app_name }}</h3>
                    <p class=\"text-gray-400\">The PHP framework for web artisans.</p>
                </div>
                <div>
                    <h4 class=\"font-bold mb-4\">Resources</h4>
                    <ul class=\"space-y-2\">
                        <li><a href=\"/docs\" class=\"text-gray-400 hover:text-white\">Documentation</a></li>
                        <li><a href=\"/api\" class=\"text-gray-400 hover:text-white\">API Reference</a></li>
                        <li><a href=\"https://github.com/your-repo\" class=\"text-gray-400 hover:text-white\">GitHub</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class=\"font-bold mb-4\">Company</h4>
                    <ul class=\"space-y-2\">
                        <li><a href=\"/about\" class=\"text-gray-400 hover:text-white\">About Us</a></li>
                        <li><a href=\"/blog\" class=\"text-gray-400 hover:text-white\">Blog</a></li>
                        <li><a href=\"/careers\" class=\"text-gray-400 hover:text-white\">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class=\"font-bold mb-4\">Legal</h4>
                    <ul class=\"space-y-2\">
                        <li><a href=\"/privacy\" class=\"text-gray-400 hover:text-white\">Privacy Policy</a></li>
                        <li><a href=\"/terms\" class=\"text-gray-400 hover:text-white\">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"border-t border-gray-700 mt-12 pt-8 text-center text-gray-400\">
                <p>&copy; {{ \"now\"|date(\"Y\") }} {{ app_name }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>", "frontend/home.twig", "/home/volk/project/rnd/laravel/project/templates/frontend/home.twig");
    }
}
