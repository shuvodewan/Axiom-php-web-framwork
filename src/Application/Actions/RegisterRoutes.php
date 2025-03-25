<?php

namespace Axiom\Application\Actions;

use Axiom\Core\Attribute\Delete;
use Axiom\Core\Attribute\Get;
use Axiom\Core\Attribute\Group;
use Axiom\Core\Attribute\Patch;
use Axiom\Core\Attribute\Post;
use Axiom\Core\Attribute\Put;
use Axiom\Core\Attribute\Route;
use Axiom\Filesystem\LocalDriver;
use Axiom\Http\Router;
use ReflectionClass;

class RegisterRoutes
{
    
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
                $this->generateRoute($reflection, $className);
            }
        }
    }

    protected function generateRoute(ReflectionClass $reflection, $className){

        if($group = $this->groupAttribute($reflection)){
            $group->newInstance()->setGroup(function() use($reflection, $className){
                $this->processRoutes($reflection, $className);
            });
        }else{
            $this->processRoutes($reflection, $className);
        }
        
    }

    protected function processRoutes(ReflectionClass $reflection, $className){
        foreach ($reflection->getMethods() as $method) {
            $attributes = [];

            $this->getRouteAttribute($method, $attributes)
            ->postRouteAttribute($method, $attributes)
            ->putRouteAttribute($method, $attributes)
            ->patchRouteAttribute($method, $attributes)
            ->deleteRouteAttribute($method, $attributes);
            foreach ($attributes as $attribute) {
                $attribute->newInstance()->register($className, $method->getName());
            }
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

    protected function getRouteAttribute($action , array &$attributes) :self
    {
        $items = $action->getAttributes(Get::class);
        $attributes = array_merge($attributes, $items);

        return $this;
    }

    protected function postRouteAttribute($action , array &$attributes) :self
    {
        $items = $action->getAttributes(Post::class);

        $attributes = array_merge($attributes, $items);
        
        return $this;
    }

    protected function putRouteAttribute($action , array &$attributes) :self
    {
        $items = $action->getAttributes(Put::class);

        $attributes = array_merge($attributes, $items);
        
        return $this;
    }

    protected function patchRouteAttribute($action , array &$attributes) :self
    {
        $items = $action->getAttributes(Patch::class);

        $attributes = array_merge($attributes, $items);
        
        return $this;
    }

    protected function deleteRouteAttribute($action , array &$attributes) :self
    {
        $items = $action->getAttributes(Delete::class);

        $attributes = array_merge($attributes, $items);
        
        return $this;
    }

    protected function groupAttribute($class)
    {
        $items = $class->getAttributes(Group::class);

        return empty($items)?null:$items[0];
        
    }
}