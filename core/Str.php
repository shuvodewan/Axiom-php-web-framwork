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

    public function plural($word)
    {
        $irregular = [
            'child' => 'children',
            'person' => 'people',
            'man' => 'men',
            'woman' => 'women',
            'tooth' => 'teeth',
            'foot' => 'feet',
            'mouse' => 'mice',
            'goose' => 'geese',
            'ox' => 'oxen'
        ];

        if (isset($irregular[$word])) {
            return $irregular[$word];
        }

        if (preg_match('/(s|x|z|ch|sh)$/i', $word)) {
            return $word . 'es';
        }

        if (preg_match('/y$/i', $word) && !preg_match('/[aeiou]y$/i', $word)) {
            return substr($word, 0, -1) . 'ies';
        }

        if (preg_match('/(f|fe)$/i', $word)) {
            return preg_replace('/(f|fe)$/i', 'ves', $word);
        }

        return $word . 's';
    }

    public function singular($word)
    {
        $irregular = [
            'children' => 'child',
            'people' => 'person',
            'men' => 'man',
            'women' => 'woman',
            'teeth' => 'tooth',
            'feet' => 'foot',
            'mice' => 'mouse',
            'geese' => 'goose',
            'oxen' => 'ox'
        ];

        if (isset($irregular[$word])) {
            return $irregular[$word];
        }

        if (preg_match('/(s|x|z|ch|sh)es$/i', $word)) {
            return substr($word, 0, -2);
        }

        if (preg_match('/ies$/i', $word) && !preg_match('/[aeiou]ies$/i', $word)) {
            return substr($word, 0, -3) . 'y';
        }

        if (preg_match('/ves$/i', $word)) {
            return preg_replace('/ves$/i', 'f', $word);
        }

        if (preg_match('/s$/i', $word) && !preg_match('/ss$/i', $word)) {
            return substr($word, 0, -1);
        }

        return $word;
    }
}