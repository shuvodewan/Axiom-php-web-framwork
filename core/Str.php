<?php

namespace Core;

class Str

{
    public function camelToPascal($string) {
        return ucfirst($string);
    }


    public function pascalToCamel($string) {
        return lcfirst($string);
    }


    public function camelToSnake($string) {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }


    public function snakeToCamel($string) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }


    public function camelToKebab($string) {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $string));
    }


    public function kebabToCamel($string) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $string))));
    }


    public function pascalToSnake($string) {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }


    public function snakeToPascal($string) {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }


    public function pascalToKebab($string) {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $string));
    }

    public function kebabToPascal($string) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }


    public function snakeToKebab($string) {
        return str_replace('_', '-', $string);
    }


    public function kebabToSnake($string) {
        return str_replace('-', '_', $string);
    }

    public function toSlug($string) {
        $slug = strtolower($string);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    public function toLower($string) {
        return strtolower($string);
    }

    public function toUpper($string) {
        return strtoupper($string);
    }

    public function unique(){
        return bin2hex(random_bytes(16));
    }
}