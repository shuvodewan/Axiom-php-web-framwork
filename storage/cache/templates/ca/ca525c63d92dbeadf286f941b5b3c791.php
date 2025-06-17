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
class __TwigTemplate_ee061ba8b2ed414d83d3e30cdce7dbde extends Template
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
        yield "<footer class=\"fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 py-3 px-6 text-center text-sm text-gray-500\" style=\"margin-left: 260px;\">
    <div class=\"flex flex-col md:flex-row justify-between items-center\">
        <div>
            &copy; ";
        // line 4
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('config')->getCallable()("app.name"), "html", null, true);
        yield ". All rights reserved.
        </div>
        <div class=\"mt-2 md:mt-0\">
            <a href=\"#\" class=\"hover:text-gray-700\">Privacy Policy</a>
            <span class=\"mx-2\">•</span>
            <a href=\"#\" class=\"hover:text-gray-700\">Terms of Service</a>
            <span class=\"mx-2\">•</span>
            <a href=\"#\" class=\"hover:text-gray-700\">Contact Us</a>
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
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  47 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<footer class=\"fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 py-3 px-6 text-center text-sm text-gray-500\" style=\"margin-left: 260px;\">
    <div class=\"flex flex-col md:flex-row justify-between items-center\">
        <div>
            &copy; {{ \"now\"|date(\"Y\") }} {{config('app.name')}}. All rights reserved.
        </div>
        <div class=\"mt-2 md:mt-0\">
            <a href=\"#\" class=\"hover:text-gray-700\">Privacy Policy</a>
            <span class=\"mx-2\">•</span>
            <a href=\"#\" class=\"hover:text-gray-700\">Terms of Service</a>
            <span class=\"mx-2\">•</span>
            <a href=\"#\" class=\"hover:text-gray-700\">Contact Us</a>
        </div>
    </div>
</footer>", "layouts/backend/partials/footer.twig", "/home/volk/project/rnd/laravel/project/templates/layouts/backend/partials/footer.twig");
    }
}
