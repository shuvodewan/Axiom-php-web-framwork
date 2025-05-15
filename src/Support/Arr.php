<?php

namespace Axiom\Support;

use ArrayAccess;

/**
 * Array utility class providing convenient methods for array manipulation.
 * This is a standalone implementation similar to Laravel's Arr helper.
 */
class Arr
{
    /**
     * Determine whether the given value is array accessible.
     *
     * @param mixed $value Value to check
     * @return bool True if accessible as array, false otherwise
     * 
     * @example
     * $arr = new Arr();
     * $arr->accessible([]); // true
     * $arr->accessible(new ArrayObject()); // true
     * $arr->accessible('string'); // false
     */
    public function accessible($value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Add an element to an array using dot notation if it doesn't exist.
     *
     * @param array $array Input array
     * @param string $key Dot notation key
     * @param mixed $value Value to add
     * @return array Modified array
     * 
     * @example
     * $array = ['user' => ['name' => 'John']];
     * $arr->add($array, 'user.age', 30); 
     * // Returns ['user' => ['name' => 'John', 'age' => 30]]
     */
    public function add(array $array, string $key, $value): array
    {
        if ($this->get($array, $key) === null) {
            return $this->set($array, $key, $value);
        }
        return $array;
    }

    /**
     * Collapse an array of arrays into a single flat array.
     *
     * @param array $array Array of arrays to collapse
     * @return array Flattened array
     * 
     * @example
     * $arr->collapse([[1, 2], [3, 4], [5]]); 
     * // Returns [1, 2, 3, 4, 5]
     */
    public function collapse(array $array): array
    {
        $results = [];
        foreach ($array as $values) {
            if (is_array($values)) {
                $results = array_merge($results, $values);
            }
        }
        return $results;
    }

    /**
     * Cross join the given arrays, returning all possible permutations.
     *
     * @param array ...$arrays Arrays to cross join
     * @return array Cartesian product
     * 
     * @example
     * $arr->crossJoin([1, 2], ['a', 'b']);
     * // Returns [
     * //     [1, 'a'], [1, 'b'],
     * //     [2, 'a'], [2, 'b']
     * // ]
     */
    public function crossJoin(...$arrays): array
    {
        $results = [[]];
        foreach ($arrays as $index => $array) {
            $append = [];
            foreach ($results as $product) {
                foreach ($array as $item) {
                    $product[$index] = $item;
                    $append[] = $product;
                }
            }
            $results = $append;
        }
        return $results;
    }

    /**
     * Divide an array into two arrays - one with keys and one with values.
     *
     * @param array $array Input array
     * @return array [keys, values]
     * 
     * @example
     * $arr->divide(['name' => 'John', 'age' => 30]);
     * // Returns [['name', 'age'], ['John', 30]]
     */
    public function divide(array $array): array
    {
        return [array_keys($array), array_values($array)];
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param array $array Array to flatten
     * @param string $prepend String to prepend to keys
     * @return array Flattened array
     * 
     * @example
     * $array = ['user' => ['name' => 'John', 'languages' => ['PHP', 'JavaScript']]];
     * $arr->dot($array);
     * // Returns [
     * //     'user.name' => 'John',
     * //     'user.languages.0' => 'PHP',
     * //     'user.languages.1' => 'JavaScript'
     * // ]
     */
    public function dot(array $array, string $prepend = ''): array
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, $this->dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$key] = $value;
            }
        }
        return $results;
    }

    /**
     * Get all array elements except specified keys.
     *
     * @param array $array Input array
     * @param array|string $keys Keys to exclude
     * @return array Filtered array
     * 
     * @example
     * $array = ['name' => 'John', 'age' => 30, 'city' => 'NY'];
     * $arr->except($array, ['age', 'city']);
     * // Returns ['name' => 'John']
     */
    public function except(array $array, $keys): array
    {
        $this->forget($array, $keys);
        return $array;
    }

    /**
     * Check if key exists in array (supports dot notation).
     *
     * @param array $array Input array
     * @param string|int $key Key to check
     * @return bool True if exists, false otherwise
     * 
     * @example
     * $array = ['user' => ['name' => 'John']];
     * $arr->exists($array, 'user.name'); // true
     * $arr->exists($array, 'user.age'); // false
     */
    public function exists(array $array, $key): bool
    {
        return array_key_exists($key, $array);
    }

    /**
     * Get first element matching condition or first element.
     *
     * @param array $array Input array
     * @param callable|null $callback Optional test callback
     * @param mixed $default Default value if not found
     * @return mixed First matching element or default
     * 
     * @example
     * $array = [100, 200, 300];
     * $arr->first($array); // 100
     * $arr->first($array, function ($value) { return $value > 150; }); // 200
     */
    public function first(array $array, ?callable $callback = null, $default = null)
    {
        if ($callback === null) {
            return empty($array) ? $default : reset($array);
        }

        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param array $array Array to flatten
     * @param int $depth Flattening depth
     * @return array Flattened array
     * 
     * @example
     * $array = ['a' => 1, 'b' => ['c' => [2, 3]]];
     * $arr->flatten($array);
     * // Returns [1, 2, 3]
     */
    public function flatten(array $array, int $depth = INF): array
    {
        $result = [];
        foreach ($array as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } else {
                $values = $depth === 1 
                    ? array_values($item) 
                    : $this->flatten($item, $depth - 1);
                foreach ($values as $value) {
                    $result[] = $value;
                }
            }
        }
        return $result;
    }

    /**
     * Remove one or many array items using dot notation.
     *
     * @param array &$array Array to modify (passed by reference)
     * @param array|string $keys Keys to remove
     * @return void
     * 
     * @example
     * $array = ['user' => ['name' => 'John', 'age' => 30]];
     * $arr->forget($array, 'user.age');
     * // $array becomes ['user' => ['name' => 'John']]
     */
    public function forget(array &$array, $keys): void
    {
        $keys = (array) $keys;
        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            if ($this->exists($array, $key)) {
                unset($array[$key]);
                continue;
            }

            $parts = explode('.', $key);
            $temp = &$array;

            while (count($parts) > 1) {
                $part = array_shift($parts);
                if (isset($temp[$part]) && is_array($temp[$part])) {
                    $temp = &$temp[$part];
                } else {
                    continue 2;
                }
            }

            unset($temp[array_shift($parts)]);
        }
    }

    /**
     * Get item from array using dot notation.
     *
     * @param array $array Input array
     * @param string|int|null $key Dot notation key
     * @param mixed $default Default value if not found
     * @return mixed Found value or default
     * 
     * @example
     * $array = ['user' => ['name' => 'John', 'age' => 30]];
     * $arr->get($array, 'user.name'); // 'John'
     * $arr->get($array, 'user.location', 'Unknown'); // 'Unknown'
     */
    public function get(array $array, $key, $default = null)
    {
        if (!$this->accessible($array)) {
            return $default;
        }

        if ($key === null) {
            return $array;
        }

        if ($this->exists($array, $key)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment) {
            if ($this->accessible($array) && $this->exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    /**
     * Check if item exists using dot notation.
     *
     * @param array $array Input array
     * @param string|array $keys Key(s) to check
     * @return bool True if all keys exist
     * 
     * @example
     * $array = ['user' => ['name' => 'John']];
     * $arr->has($array, 'user.name'); // true
     * $arr->has($array, ['user.name', 'user.age']); // false
     */
    /**
 * Check if an item or items exist in an array using "dot" notation.
 * Returns false if any value in the path is null.
 *
 * @param array $array Input array
 * @param string|array $keys Key(s) to check
 * @return bool True if all keys exist and no null values in path, false otherwise
 * 
 * @example
 * $array = ['user' => ['name' => 'John', 'age' => null]];
 * $arr->has($array, 'user.name'); // true
 * $arr->has($array, 'user.age'); // false (because age is null)
 * $arr->has($array, 'user.location'); // false (doesn't exist)
 */
public function has(array $array, $keys): bool
{
    $keys = (array) $keys;
    if (!$array || $keys === []) {
        return false;
    }

    foreach ($keys as $key) {
        $subArray = $array;
        
        if ($this->exists($array, $key)) {
            if ($array[$key] === null) {
                return false;
            }
            continue;
        }

        foreach (explode('.', $key) as $segment) {
            if ($this->accessible($subArray) && $this->exists($subArray, $segment)) {
                $subArray = $subArray[$segment];
                if ($subArray === null) {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    return true;
}

    /**
     * Check if any of the items exist using dot notation.
     *
     * @param array $array Input array
     * @param string|array $keys Key(s) to check
     * @return bool True if any key exists
     * 
     * @example
     * $array = ['user' => ['name' => 'John']];
     * $arr->hasAny($array, ['user.name', 'user.age']); // true
     */
    public function hasAny(array $array, $keys): bool
    {
        if ($keys === null) {
            return false;
        }

        $keys = (array) $keys;
        if (!$array) {
            return false;
        }

        foreach ($keys as $key) {
            if ($this->has($array, $key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines if an array is associative.
     *
     * @param array $array Array to check
     * @return bool True if associative, false if sequential
     * 
     * @example
     * $arr->isAssoc(['a' => 1, 'b' => 2]); // true
     * $arr->isAssoc([0 => 'a', 1 => 'b']); // false
     */
    public function isAssoc(array $array): bool
    {
        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
    }

    /**
     * Get last element matching condition or last element.
     *
     * @param array $array Input array
     * @param callable|null $callback Optional test callback
     * @param mixed $default Default value if not found
     * @return mixed Last matching element or default
     * 
     * @example
     * $array = [100, 200, 300];
     * $arr->last($array); // 300
     * $arr->last($array, function ($value) { return $value < 250; }); // 200
     */
    public function last(array $array, callable $callback = null, $default = null)
    {
        if ($callback === null) {
            return empty($array) ? $default : end($array);
        }

        return $this->first(array_reverse($array, true), $callback, $default);
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param array $array Input array
     * @param array|string $keys Keys to include
     * @return array Filtered array
     * 
     * @example
     * $array = ['name' => 'John', 'age' => 30, 'city' => 'NY'];
     * $arr->only($array, ['name', 'age']);
     * // Returns ['name' => 'John', 'age' => 30]
     */
    public function only(array $array, $keys): array
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * Pluck values from array of arrays/objects.
     *
     * @param array $array Input array
     * @param string|array $value Value to pluck
     * @param string|array|null $key Key to index by
     * @return array Plucked values
     * 
     * @example
     * $array = [
     *     ['id' => 1, 'name' => 'John'],
     *     ['id' => 2, 'name' => 'Jane']
     * ];
     * $arr->pluck($array, 'name'); // ['John', 'Jane']
     * $arr->pluck($array, 'name', 'id'); // [1 => 'John', 2 => 'Jane']
     */
    public function pluck(array $array, $value, $key = null): array
    {
        $results = [];
        [$value, $key] = $this->explodePluckParameters($value, $key);

        foreach ($array as $item) {
            $itemValue = $this->dataGet($item, $value);
            
            if ($key === null) {
                $results[] = $itemValue;
            } else {
                $itemKey = $this->dataGet($item, $key);
                if (is_object($itemKey) && method_exists($itemKey, '__toString')) {
                    $itemKey = (string) $itemKey;
                }
                $results[$itemKey] = $itemValue;
            }
        }

        return $results;
    }

    /**
     * Push an item onto the beginning of an array.
     *
     * @param array $array Input array
     * @param mixed $value Value to prepend
     * @param mixed $key Key to use (optional)
     * @return array Modified array
     * 
     * @example
     * $arr->prepend([1, 2, 3], 0); // [0, 1, 2, 3]
     * $arr->prepend(['b' => 2, 'c' => 3], 1, 'a'); // ['a' => 1, 'b' => 2, 'c' => 3]
     */
    public function prepend(array $array, $value, $key = null): array
    {
        if ($key === null) {
            array_unshift($array, $value);
        } else {
            $array = [$key => $value] + $array;
        }
        return $array;
    }

    /**
     * Get a value from the array, and remove it.
     *
     * @param array &$array Array to modify (passed by reference)
     * @param string $key Key to pull
     * @param mixed $default Default value if not found
     * @return mixed The pulled value
     * 
     * @example
     * $array = ['name' => 'John', 'age' => 30];
     * $arr->pull($array, 'name'); // 'John'
     * // $array becomes ['age' => 30]
     */
    public function pull(array &$array, $key, $default = null)
    {
        $value = $this->get($array, $key, $default);
        $this->forget($array, $key);
        return $value;
    }

    /**
     * Get one or more items randomly from the array.
     *
     * @param array $array Input array
     * @param int|null $number Number of items to return
     * @return mixed Single item if $number is null, array otherwise
     * 
     * @example
     * $array = [1, 2, 3, 4, 5];
     * $arr->random($array); // Returns random item (e.g. 3)
     * $arr->random($array, 2); // Returns array with 2 random items (e.g. [2, 5])
     */
    public function random(array $array, int $number = null)
    {
        $requested = $number === null ? 1 : $number;
        $count = count($array);

        if ($requested > $count) {
            throw new InvalidArgumentException(
                "You requested {$requested} items, but there are only {$count} items available."
            );
        }

        if ($number === null) {
            return $array[array_rand($array)];
        }

        $keys = array_rand($array, $number);
        $results = [];
        foreach ((array) $keys as $key) {
            $results[] = $array[$key];
        }
        return $results;
    }

    /**
     * Set array item using dot notation.
     *
     * @param array $array Input array
     * @param string $key Dot notation key
     * @param mixed $value Value to set
     * @return array Modified array
     * 
     * @example
     * $array = ['user' => ['name' => 'John']];
     * $arr->set($array, 'user.age', 30);
     * // Returns ['user' => ['name' => 'John', 'age' => 30]]
     */
    public function set(array $array, $key, $value): array
    {
        if ($key === null) {
            return $array = $value;
        }

        $keys = explode('.', $key);
        $temp = &$array;

        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($temp[$key]) || !is_array($temp[$key])) {
                $temp[$key] = [];
            }
            $temp = &$temp[$key];
        }

        $temp[array_shift($keys)] = $value;
        return $array;
    }

    /**
     * Shuffle the given array.
     *
     * @param array $array Array to shuffle
     * @param int|null $seed Random seed
     * @return array Shuffled array
     * 
     * @example
     * $arr->shuffle([1, 2, 3, 4]); // e.g. [3, 1, 4, 2]
     */
    public function shuffle(array $array, int $seed = null): array
    {
        if ($seed !== null) {
            mt_srand($seed);
        }
        
        shuffle($array);
        
        if ($seed !== null) {
            mt_srand();
        }
        
        return $array;
    }

    /**
     * Sort the array using the given callback.
     *
     * @param array $array Array to sort
     * @param callable|null $callback Sort callback
     * @return array Sorted array
     * 
     * @example
     * $arr->sort([3, 1, 2]); // [1, 2, 3]
     * $arr->sort(['a' => 3, 'b' => 1, 'c' => 2], function($a, $b) { return $a <=> $b; });
     * // ['b' => 1, 'c' => 2, 'a' => 3]
     */
    public function sort(array $array, ?callable $callback = null): array
    {
        $callback = $callback ?: function ($value, $key) {
            return $value;
        };

        $results = [];
        foreach ($array as $key => $value) {
            $results[$key] = $callback($value, $key);
        }

        asort($results, SORT_REGULAR);

        $sorted = [];
        foreach (array_keys($results) as $key) {
            $sorted[$key] = $array[$key];
        }

        return $sorted;
    }

    /**
     * Recursively sort an array by keys and values.
     *
     * @param array $array Array to sort
     * @return array Sorted array
     * 
     * @example
     * $array = ['b' => ['b' => 2, 'a' => 1], 'a' => 3];
     * $arr->sortRecursive($array);
     * // Returns ['a' => 3, 'b' => ['a' => 1, 'b' => 2]]
     */
    public function sortRecursive(array $array): array
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = $this->sortRecursive($value);
            }
        }

        if ($this->isAssoc($array)) {
            ksort($array);
        } else {
            sort($array);
        }

        return $array;
    }

    /**
     * Convert the array into a query string.
     *
     * @param array $array Array to convert
     * @return string Query string
     * 
     * @example
     * $arr->query(['name' => 'John', 'age' => 30]);
     * // Returns 'name=John&age=30'
     */
    public function query(array $array): string
    {
        return http_build_query($array, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * Filter the array using the given callback.
     *
     * @param array $array Array to filter
     * @param callable $callback Filter callback
     * @return array Filtered array
     * 
     * @example
     * $arr->where([1, 2, 3, 4], function($value) { return $value > 2; });
     * // Returns [3, 4]
     */
    public function where(array $array, callable $callback): array
    {
        return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * If the given value is not an array, wrap it in one.
     *
     * @param mixed $value Value to wrap
     * @return array Wrapped array
     * 
     * @example
     * $arr->wrap('John'); // ['John']
     * $arr->wrap(['John']); // ['John']
     */
    public function wrap($value): array
    {
        return is_array($value) ? $value : [$value];
    }

    /**
     * Explode the pluck parameters.
     *
     * @param mixed $value Value parameter
     * @param mixed $key Key parameter
     * @return array Exploded parameters
     */
    protected function explodePluckParameters($value, $key): array
    {
        $value = is_string($value) ? explode('.', $value) : $value;
        $key = $key === null || is_array($key) ? $key : explode('.', $key);
        return [$value, $key];
    }

    /**
     * Get an item from an array or object using dot notation.
     *
     * @param mixed $target Array or object
     * @param mixed $key Key to get
     * @param mixed $default Default value
     * @return mixed Found value or default
     */
    protected function dataGet($target, $key, $default = null)
    {
        if ($key === null) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        foreach ($key as $segment) {
            if (is_array($target) && array_key_exists($segment, $target)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return $default;
            }
        }

        return $target;
    }
}