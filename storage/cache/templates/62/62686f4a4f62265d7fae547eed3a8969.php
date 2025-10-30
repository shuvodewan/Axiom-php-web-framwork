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

/* layouts/backend/partials/footer.twig */
class __TwigTemplate_e2175845aeee808d717f8c1608e72ce6 extends Template
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
        yield " <footer class=\"bg-white border-t border-gray-200 p-4\">
    <div class=\"flex flex-col md:flex-row items-center justify-between\">
        <p class=\"text-sm text-gray-600\">© 2023 AdminPanel. All rights reserved.</p>
        <div class=\"flex space-x-4 mt-2 md:mt-0\">
            <a href=\"#\" class=\"text-sm text-gray-600 hover:text-primary-500\">Privacy Policy</a>
            <a href=\"#\" class=\"text-sm text-gray-600 hover:text-primary-500\">Terms of Service</a>
            <a href=\"#\" class=\"text-sm text-gray-600 hover:text-primary-500\">Contact Us</a>
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
        return "layouts/backend/partials/footer.twig";
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
        return new Source(" <footer class=\"bg-white border-t border-gray-200 p-4\">
    <div class=\"flex flex-col md:flex-row items-center justify-between\">
        <p class=\"text-sm text-gray-600\">© 2023 AdminPanel. All rights reserved.</p>
        <div class=\"flex space-x-4 mt-2 md:mt-0\">
            <a href=\"#\" class=\"text-sm text-gray-600 hover:text-primary-500\">Privacy Policy</a>
            <a href=\"#\" class=\"text-sm text-gray-600 hover:text-primary-500\">Terms of Service</a>
            <a href=\"#\" class=\"text-sm text-gray-600 hover:text-primary-500\">Contact Us</a>
        </div>
    </div>
</footer>", "layouts/backend/partials/footer.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/backend/partials/footer.twig");
    }
}
