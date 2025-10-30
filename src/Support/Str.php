<?php

namespace Axiom\Support;

/**
 * Class Str
 *
 * Provides utility methods for string manipulation, including case conversion, slug generation,
 * and pluralization/singularization of words.
 */
class Str
{
    /**
     * Convert a camelCase string to PascalCase.
     *
     * @param string $string The camelCase string.
     * @return string The PascalCase string.
     */
    public function camelToPascal(string $string): string
    {
        return ucfirst($string);
    }

    /**
     * Convert a PascalCase string to camelCase.
     *
     * @param string $string The PascalCase string.
     * @return string The camelCase string.
     */
    public function pascalToCamel(string $string): string
    {
        return lcfirst($string);
    }

    /**
     * Convert a camelCase string to snake_case.
     *
     * @param string $string The camelCase string.
     * @return string The snake_case string.
     */
    public function camelToSnake(string $string): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }

    /**
     * Convert a snake_case string to camelCase.
     *
     * @param string $string The snake_case string.
     * @return string The camelCase string.
     */
    public function snakeToCamel(string $string): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }

    /**
     * Convert a camelCase string to kebab-case.
     *
     * @param string $string The camelCase string.
     * @return string The kebab-case string.
     */
    public function camelToKebab(string $string): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $string));
    }

    /**
     * Convert a kebab-case string to camelCase.
     *
     * @param string $string The kebab-case string.
     * @return string The camelCase string.
     */
    public function kebabToCamel(string $string): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $string))));
    }

    /**
     * Convert a PascalCase string to snake_case.
     *
     * @param string $string The PascalCase string.
     * @return string The snake_case string.
     */
    public function pascalToSnake(string $string): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }

    /**
     * Convert a snake_case string to PascalCase.
     *
     * @param string $string The snake_case string.
     * @return string The PascalCase string.
     */
    public function snakeToPascal(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * Convert a PascalCase string to kebab-case.
     *
     * @param string $string The PascalCase string.
     * @return string The kebab-case string.
     */
    public function pascalToKebab(string $string): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $string));
    }

    /**
     * Convert a kebab-case string to PascalCase.
     *
     * @param string $string The kebab-case string.
     * @return string The PascalCase string.
     */
    public function kebabToPascal(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert a snake_case string to kebab-case.
     *
     * @param string $string The snake_case string.
     * @return string The kebab-case string.
     */
    public function snakeToKebab(string $string): string
    {
        return str_replace('_', '-', $string);
    }

    /**
     * Convert a kebab-case string to snake_case.
     *
     * @param string $string The kebab-case string.
     * @return string The snake_case string.
     */
    public function kebabToSnake(string $string): string
    {
        return str_replace('-', '_', $string);
    }

    /**
     * Convert a string to a slug.
     *
     * @param string $string The string to convert.
     * @return string The slug.
     */
    public function toSlug(string $string): string
    {
        $slug = strtolower($string);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    /**
     * Convert a string to lowercase.
     *
     * @param string $string The string to convert.
     * @return string The lowercase string.
     */
    public function toLower(string $string): string
    {
        return strtolower($string);
    }

    /**
     * Convert a string to uppercase.
     *
     * @param string $string The string to convert.
     * @return string The uppercase string.
     */
    public function toUpper(string $string): string
    {
        return strtoupper($string);
    }

    /**
     * Generate a unique string.
     *
     * @return string A unique string.
     */
    public function unique(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Convert a string to title case (e.g., "user_name" becomes "User Name")
     *
     * @param string $string The string to convert
     * @return string The title-cased string
     */
    public function title(string $string): string
    {
        return ucwords(str_replace(['_', '-'], ' ', $string));
    }

    /**
     * Convert a string to title case without spaces (e.g., "user_name" becomes "UserName")
     *
     * @param string $string The string to convert
     * @return string The title-cased string without spaces
     */
    public function studly(string $string): string
    {
        return str_replace(' ', '', $this->title($string));
    }

    /**
     * Convert a word to its plural form.
     *
     * @param string $word The word to pluralize.
     * @return string The plural form of the word.
     */
    public function plural(string $word): string
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
            'ox' => 'oxen',
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

    /**
     * Convert a word to its singular form.
     *
     * @param string $word The word to singularize.
     * @return string The singular form of the word.
     */
    public function singular(string $word): string
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
            'oxen' => 'ox',
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