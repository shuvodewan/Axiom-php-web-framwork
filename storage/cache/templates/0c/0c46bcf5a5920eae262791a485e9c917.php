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

/* mails/forgetPassword.twig */
class __TwigTemplate_dc0731958171dd7d38863e1071d8e732 extends Template
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
        yield "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"UTF-8\">
    <title>Welcome to MyApp</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: auto; padding: 20px; background: #f9f9f9; border-radius: 8px; }
        .header { background: #4CAF50; color: white; padding: 10px 20px; border-radius: 8px 8px 0 0; }
        .footer { font-size: 12px; color: #999; text-align: center; margin-top: 20px; }
        a.button { background: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h2>Welcome to MyApp!</h2>
        </div>

        <p>Hi there,</p>

        <p>Thanks for signing up. We're excited to have you on board! You can now log in and start exploring what we have to offer.</p>

        <p>
            Please confirm your email by clicking the button below:
            <br>
            <a href=\"https://myapp.com/confirm\" class=\"button\">Confirm Email</a>
        </p>

        <p>If you have any questions, feel free to reach out.</p>

        <p>Cheers,<br>The MyApp Team</p>

        <div class=\"footer\">
            © 2025 MyApp. All rights reserved.
        </div>
    </div>
</body>
</html>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "mails/forgetPassword.twig";
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
        return new Source("<!DOCTYPE html>
<html>
<head>
    <meta charset=\"UTF-8\">
    <title>Welcome to MyApp</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: auto; padding: 20px; background: #f9f9f9; border-radius: 8px; }
        .header { background: #4CAF50; color: white; padding: 10px 20px; border-radius: 8px 8px 0 0; }
        .footer { font-size: 12px; color: #999; text-align: center; margin-top: 20px; }
        a.button { background: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h2>Welcome to MyApp!</h2>
        </div>

        <p>Hi there,</p>

        <p>Thanks for signing up. We're excited to have you on board! You can now log in and start exploring what we have to offer.</p>

        <p>
            Please confirm your email by clicking the button below:
            <br>
            <a href=\"https://myapp.com/confirm\" class=\"button\">Confirm Email</a>
        </p>

        <p>If you have any questions, feel free to reach out.</p>

        <p>Cheers,<br>The MyApp Team</p>

        <div class=\"footer\">
            © 2025 MyApp. All rights reserved.
        </div>
    </div>
</body>
</html>
", "mails/forgetPassword.twig", "/home/volk/project/rnd/laravel/project/templates/mails/forgetPassword.twig");
    }
}
