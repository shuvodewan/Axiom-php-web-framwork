<?php

namespace Axiom\Application\Actions;

use Axiom\Core\Attribute\Get;
use Axiom\Filesystem\LocalDriver;
use ReflectionClass;

class RegisterRoutes
{
    public function __construct()
    {
        
    }
    
    public function load(array $controllerDirs): void
    {
        $driver = new LocalDriver(['root' => '/']);
        $controllers = [];

        foreach ($controllerDirs as $dir) {
            foreach ($driver->getFiles($dir, true) as $file) {
                array_push($controllers, $file);
            }
        }

        $this->registerRoute($controllers);
    }

    public function registerRoute(array $files): void
    {
      
        foreach ($files as $file) {
            $content = file_get_contents('/' . $file);
            $className = $this->getClassFromFile(htmlspecialchars($content));
            if ($className) {
                $reflection = new ReflectionClass($className);
                $this->generateRoute($reflection);
            }
        }
    }

    protected function generateRoute(ReflectionClass $reflection){
        $attributes = $reflection->getAttributes(Get::class);
        dd($attributes);
        foreach ($attributes as $attribute) {
            $app = $attribute->newInstance();
            $installedApps[$app->name] = $class;
        }
    }

    protected function getClassFromFile(string $content): ?string
    {
        $namespacePattern = '/namespace\s+([^\s;]+);/';
        preg_match($namespacePattern, $content, $namespaceMatches);
        $namespace = $namespaceMatches[1] ?? '';

        $classPattern = '/class\s+([^\s{]+)/';
        preg_match($classPattern, $content, $classMatches);
        $className = $classMatches[1] ?? '';
        if ($namespace && $className) {
            return $namespace . '\\' . $className;
        }

        return null;
    }
}