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

/* layouts/frontend/partials/footer.twig */
class __TwigTemplate_04f2b812cdeec1d23c60d7a499b17816 extends Template
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
        yield "    <!-- Footer -->
    <footer class=\"bg-gray-900 text-gray-400\">
        <div class=\"container mx-auto px-6 py-12\">
            <div class=\"grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8\">
                <div class=\"col-span-2\">
                    <a href=\"#\" class=\"flex items-center space-x-2 mb-6\">
                        <svg class=\"w-8 h-8 text-primary-400\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path d=\"M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\"></path>
                        </svg>
                        <span class=\"text-2xl font-bold text-white\">Axiom</span>
                    </a>
                    <p class=\"text-sm mb-6\">The modern PHP framework for web artisans.</p>
                    <div class=\"flex space-x-4\">
                        <a href=\"#\" class=\"text-gray-400 hover:text-white\">
                            <svg class=\"w-5 h-5\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path d=\"M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z\"></path>
                            </svg>
                        </a>
                        <a href=\"#\" class=\"text-gray-400 hover:text-white\">
                            <svg class=\"w-5 h-5\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path d=\"M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z\"></path>
                            </svg>
                        </a>
                        <a href=\"#\" class=\"text-gray-400 hover:text-white\">
                            <svg class=\"w-5 h-5\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path d=\"M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z\"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class=\"text-sm font-semibold text-white uppercase tracking-wider mb-4\">Resources</h3>
                    <ul class=\"space-y-2\">
                        <li><a href=\"#\" class=\"hover:text-white transition\">Documentation</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">API Reference</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Guides</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Video Tutorials</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class=\"text-sm font-semibold text-white uppercase tracking-wider mb-4\">Community</h3>
                    <ul class=\"space-y-2\">
                        <li><a href=\"#\" class=\"hover:text-white transition\">GitHub</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Discord</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Twitter</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class=\"text-sm font-semibold text-white uppercase tracking-wider mb-4\">Company</h3>
                    <ul class=\"space-y-2\">
                        <li><a href=\"#\" class=\"hover:text-white transition\">About</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Careers</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Privacy</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Terms</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"mt-12 pt-8 border-t border-gray-800\">
                <p class=\"text-sm text-center\">&copy; 2023 Axiom PHP Framework. All rights reserved.</p>
            </div>
        </div>
    </footer>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "layouts/frontend/partials/footer.twig";
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
        return new Source("    <!-- Footer -->
    <footer class=\"bg-gray-900 text-gray-400\">
        <div class=\"container mx-auto px-6 py-12\">
            <div class=\"grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8\">
                <div class=\"col-span-2\">
                    <a href=\"#\" class=\"flex items-center space-x-2 mb-6\">
                        <svg class=\"w-8 h-8 text-primary-400\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                            <path d=\"M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\"></path>
                        </svg>
                        <span class=\"text-2xl font-bold text-white\">Axiom</span>
                    </a>
                    <p class=\"text-sm mb-6\">The modern PHP framework for web artisans.</p>
                    <div class=\"flex space-x-4\">
                        <a href=\"#\" class=\"text-gray-400 hover:text-white\">
                            <svg class=\"w-5 h-5\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path d=\"M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z\"></path>
                            </svg>
                        </a>
                        <a href=\"#\" class=\"text-gray-400 hover:text-white\">
                            <svg class=\"w-5 h-5\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path d=\"M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z\"></path>
                            </svg>
                        </a>
                        <a href=\"#\" class=\"text-gray-400 hover:text-white\">
                            <svg class=\"w-5 h-5\" fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                <path d=\"M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z\"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class=\"text-sm font-semibold text-white uppercase tracking-wider mb-4\">Resources</h3>
                    <ul class=\"space-y-2\">
                        <li><a href=\"#\" class=\"hover:text-white transition\">Documentation</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">API Reference</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Guides</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Video Tutorials</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class=\"text-sm font-semibold text-white uppercase tracking-wider mb-4\">Community</h3>
                    <ul class=\"space-y-2\">
                        <li><a href=\"#\" class=\"hover:text-white transition\">GitHub</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Discord</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Twitter</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class=\"text-sm font-semibold text-white uppercase tracking-wider mb-4\">Company</h3>
                    <ul class=\"space-y-2\">
                        <li><a href=\"#\" class=\"hover:text-white transition\">About</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Careers</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Privacy</a></li>
                        <li><a href=\"#\" class=\"hover:text-white transition\">Terms</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"mt-12 pt-8 border-t border-gray-800\">
                <p class=\"text-sm text-center\">&copy; 2023 Axiom PHP Framework. All rights reserved.</p>
            </div>
        </div>
    </footer>", "layouts/frontend/partials/footer.twig", "/home/volk/project/rnd/laravel/project/templates/layouts/frontend/partials/footer.twig");
    }
}
