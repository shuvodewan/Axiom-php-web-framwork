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

/* layouts/frontend/documentation.twig */
class __TwigTemplate_9d49580656a8a2a91ff9314111e1a073 extends Template
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
    <title>Documentation -   ";
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
<body class=\"font-sans antialiased text-gray-800 bg-gray-50\">
    <!-- Premium Navigation -->
   ";
        // line 13
        yield from $this->load("layouts/frontend/partials/docheader.twig", 13)->unwrap()->yield($context);
        // line 14
        yield "   <!--body-->
    <!-- Main Content -->
    <div class=\"flex pt-20\">

    ";
        // line 18
        yield from $this->load("layouts/frontend/partials/sidebar.twig", 18)->unwrap()->yield($context);
        // line 19
        yield "    
    ";
        // line 20
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 21
        yield "
    </div>

    <!-- Footer -->
    ";
        // line 25
        yield from $this->load("layouts/frontend/partials/footer.twig", 25)->unwrap()->yield($context);
        // line 26
        yield "


    <script>
        // Toggle version dropdown
        const versionDropdownButton = document.getElementById('version-dropdown-button');
        const versionDropdown = document.getElementById('version-dropdown');
        
        versionDropdownButton.addEventListener('click', () => {
            versionDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!versionDropdownButton.contains(event.target)) {
                versionDropdown.classList.add('hidden');
            }
        });
        
        // Mobile sidebar toggle (you'll need to implement the button in your mobile header)
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        function toggleMobileSidebar() {
            mobileSidebar.classList.toggle('translate-x-0');
            mobileSidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.style.display = sidebarOverlay.style.display === 'block' ? 'none' : 'block';
        }
        
    </script>
</body>
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

    // line 20
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
        return "layouts/frontend/documentation.twig";
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
        return array (  134 => 20,  124 => 6,  87 => 26,  85 => 25,  79 => 21,  77 => 20,  74 => 19,  72 => 18,  66 => 14,  64 => 13,  57 => 9,  51 => 6,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\" class=\"scroll-smooth\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Documentation -   {% block title %}{% endblock %}</title>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
    <link href=\"https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&display=swap\" rel=\"stylesheet\">
    {{vite(['project/templates/assets/css/app.css','project/templates/assets/js/app.js'])|raw}}
</head>
<body class=\"font-sans antialiased text-gray-800 bg-gray-50\">
    <!-- Premium Navigation -->
   {% include 'layouts/frontend/partials/docheader.twig' %}
   <!--body-->
    <!-- Main Content -->
    <div class=\"flex pt-20\">

    {% include 'layouts/frontend/partials/sidebar.twig' %}
    
    {% block body %}{% endblock %}

    </div>

    <!-- Footer -->
    {% include 'layouts/frontend/partials/footer.twig' %}



    <script>
        // Toggle version dropdown
        const versionDropdownButton = document.getElementById('version-dropdown-button');
        const versionDropdown = document.getElementById('version-dropdown');
        
        versionDropdownButton.addEventListener('click', () => {
            versionDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!versionDropdownButton.contains(event.target)) {
                versionDropdown.classList.add('hidden');
            }
        });
        
        // Mobile sidebar toggle (you'll need to implement the button in your mobile header)
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        function toggleMobileSidebar() {
            mobileSidebar.classList.toggle('translate-x-0');
            mobileSidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.style.display = sidebarOverlay.style.display === 'block' ? 'none' : 'block';
        }
        
    </script>
</body>
</html>
", "layouts/frontend/documentation.twig", "/home/volk/project/rnd/boilerplat/project/templates/layouts/frontend/documentation.twig");
    }
}
