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
class __TwigTemplate_7dd3b5d7e0e0303a1e89d0a15c437880 extends Template
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
        yield " - Admin Dashboard</title>
    <script src=\"https://cdn.tailwindcss.com\"></script>
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">
    ";
        // line 9
        yield (is_scalar($tmp = $this->env->getFunction('vite')->getCallable()(["project/templates/assets/css/admin.css", "project/templates/assets/js/admin.js"])) ? new Markup($tmp, $this->env->getCharset()) : $tmp);
        yield "
</head>
<body class=\"bg-gray-50 font-sans\">
    <!-- Sidebar -->
    ";
        // line 13
        yield from $this->load("layouts/backend/partials/sidebar.twig", 13)->unwrap()->yield($context);
        yield "  
    <!-- Main Content -->
    <div class=\"main-content min-h-screen\">
        <!-- Clean Topbar without breadcrumb -->
        ";
        // line 17
        yield from $this->load("layouts/backend/partials/topbar.twig", 17)->unwrap()->yield($context);
        yield "  
        <!-- Content Area -->
        <main class=\"pt-16 pb-16 px-6\">
            <!-- Page Content -->
            <div class=\"mb-6\">
                ";
        // line 22
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 23
        yield "            </div>
        </main>

        <!-- Footer -->
        ";
        // line 27
        yield from $this->load("layouts/backend/partials/footer.twig", 27)->unwrap()->yield($context);
        yield "  
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });

        // Toggle user menu
        document.getElementById('userMenuButton').addEventListener('click', function() {
            document.getElementById('userMenu').classList.toggle('hidden');
        });

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userMenuButton = document.getElementById('userMenuButton');
            
            if (!userMenu.contains(event.target)) {
                if (event.target !== userMenuButton && !userMenuButton.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            }
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
        return array (  132 => 22,  86 => 27,  80 => 23,  78 => 22,  70 => 17,  63 => 13,  56 => 9,  50 => 6,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{{config('app.name')}} - Admin Dashboard</title>
    <script src=\"https://cdn.tailwindcss.com\"></script>
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">
    {{vite(['project/templates/assets/css/admin.css','project/templates/assets/js/admin.js'])|raw}}
</head>
<body class=\"bg-gray-50 font-sans\">
    <!-- Sidebar -->
    {% include 'layouts/backend/partials/sidebar.twig' %}  
    <!-- Main Content -->
    <div class=\"main-content min-h-screen\">
        <!-- Clean Topbar without breadcrumb -->
        {% include 'layouts/backend/partials/topbar.twig' %}  
        <!-- Content Area -->
        <main class=\"pt-16 pb-16 px-6\">
            <!-- Page Content -->
            <div class=\"mb-6\">
                {% block body %}{% endblock %}
            </div>
        </main>

        <!-- Footer -->
        {% include 'layouts/backend/partials/footer.twig' %}  
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });

        // Toggle user menu
        document.getElementById('userMenuButton').addEventListener('click', function() {
            document.getElementById('userMenu').classList.toggle('hidden');
        });

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userMenuButton = document.getElementById('userMenuButton');
            
            if (!userMenu.contains(event.target)) {
                if (event.target !== userMenuButton && !userMenuButton.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            }
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
</html>", "layouts/backend/app.twig", "/home/volk/project/rnd/laravel/project/templates/layouts/backend/app.twig");
    }
}
