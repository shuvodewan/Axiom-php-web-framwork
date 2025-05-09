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

/* layouts/backend/app.twig */
class __TwigTemplate_efbcbe34ead750c3dce97e4ae37eec46 extends Template
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
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('config')->getCallable()("app.name"), "html", null, true);
        yield " - ";
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
    <script src=\"https://cdn.tailwindcss.com\"></script>
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">
    ";
        // line 9
        yield (is_scalar($tmp = $this->env->getFunction('vite')->getCallable()(["project/templates/assets/css/app.css", "project/templates/assets/js/app.js"])) ? new Markup($tmp, $this->env->getCharset()) : $tmp);
        yield "
</head>
<body class=\"bg-gray-50\">
   
    <!-- sidebar -->
    ";
        // line 14
        yield from $this->load("layouts/backend/partials/sidebar.twig", 14)->unwrap()->yield($context);
        // line 15
        yield "    <!-- Main Content -->
    <div class=\"main-content min-h-screen\">
        <!-- Topbar -->
         ";
        // line 18
        yield from $this->load("layouts/backend/partials/topbar.twig", 18)->unwrap()->yield($context);
        // line 19
        yield "
        <!-- Dashboard Content -->
        <main class=\"p-6\">
          ";
        // line 22
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 23
        yield "        </main>

    </div>

    <script>
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });
        
        // Responsive behavior - collapse sidebar on small screens
        function handleResize() {
            if (window.innerWidth < 768) {
                document.querySelector('.sidebar').classList.add('collapsed');
            }
        }
        
        // Initial check
        handleResize();
        
        // Add event listener
        window.addEventListener('resize', handleResize);
    </script>
</body>
</html>";
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

    // line 22
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
        return "layouts/backend/app.twig";
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
        return array (  122 => 22,  112 => 6,  83 => 23,  81 => 22,  76 => 19,  74 => 18,  69 => 15,  67 => 14,  59 => 9,  51 => 6,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{{config('app.name')}} - {% block title %}{% endblock %}</title>
    <script src=\"https://cdn.tailwindcss.com\"></script>
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">
    {{vite(['project/templates/assets/css/app.css','project/templates/assets/js/app.js'])|raw}}
</head>
<body class=\"bg-gray-50\">
   
    <!-- sidebar -->
    {% include 'layouts/backend/partials/sidebar.twig' %}
    <!-- Main Content -->
    <div class=\"main-content min-h-screen\">
        <!-- Topbar -->
         {% include 'layouts/backend/partials/topbar.twig' %}

        <!-- Dashboard Content -->
        <main class=\"p-6\">
          {% block body %}{% endblock %}
        </main>

    </div>

    <script>
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });
        
        // Responsive behavior - collapse sidebar on small screens
        function handleResize() {
            if (window.innerWidth < 768) {
                document.querySelector('.sidebar').classList.add('collapsed');
            }
        }
        
        // Initial check
        handleResize();
        
        // Add event listener
        window.addEventListener('resize', handleResize);
    </script>
</body>
</html>", "layouts/backend/app.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/backend/app.twig");
    }
}
