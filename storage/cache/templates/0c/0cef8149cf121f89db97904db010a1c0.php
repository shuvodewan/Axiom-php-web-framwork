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

/* layouts/frontend/app.twig */
class __TwigTemplate_517771541b6664d0c3e99f5bb5f04758 extends Template
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
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\" class=\"scroll-smooth\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Axiom PHP -   ";
        // line 6
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
    <link href=\"https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&display=swap\" rel=\"stylesheet\">
    ";
        // line 9
        yield (is_scalar($tmp = $this->env->getFunction('vite')->getCallable()(["project/templates/assets/css/app.css", "project/templates/assets/js/app.js"])) ? new Markup($tmp, $this->env->getCharset()) : $tmp);
        yield "
</head>
<body class=\"bg-gray-50 font-sans antialiased text-gray-800\">
    <!-- Premium Navigation -->
   ";
        // line 13
        yield from $this->load("layouts/frontend/partials/header.twig", 13)->unwrap()->yield($context);
        // line 14
        yield "   <!--body-->
    ";
        // line 15
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 16
        yield "    <!-- Footer -->
    ";
        // line 17
        yield from $this->load("layouts/frontend/partials/footer.twig", 17)->unwrap()->yield($context);
        // line 18
        yield "</body>
</html>
";
        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 15
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "layouts/frontend/app.twig";
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
        return array (  93 => 15,  83 => 6,  76 => 18,  74 => 17,  71 => 16,  69 => 15,  66 => 14,  64 => 13,  57 => 9,  51 => 6,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\" class=\"scroll-smooth\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Axiom PHP -   {% block title %}{% endblock %}</title>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
    <link href=\"https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&display=swap\" rel=\"stylesheet\">
    {{vite(['project/templates/assets/css/app.css','project/templates/assets/js/app.js'])|raw}}
</head>
<body class=\"bg-gray-50 font-sans antialiased text-gray-800\">
    <!-- Premium Navigation -->
   {% include 'layouts/frontend/partials/header.twig' %}
   <!--body-->
    {% block body %}{% endblock %}
    <!-- Footer -->
    {% include 'layouts/frontend/partials/footer.twig' %}
</body>
</html>
", "layouts/frontend/app.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/frontend/app.twig");
    }
}
