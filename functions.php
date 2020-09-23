<?php

if (!function_exists('data_get')) {
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param object|array $target
     * @param string $key
     * @param array $params
     * @param mixed $default
     * @return mixed
     */
    function data_get($target, string $key, array $params = [], $default = null)
    {
        if ($key === null) {
            return $target;
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($target)) {
                if (!array_key_exists($segment, $target)) {
                    return value($default);
                }

                $target = $target[$segment];
            } elseif (is_object($target)) {
                if (!isset($target->{$segment})) {
                    return value($default);
                }

                $target = $target->{$segment};
            } else {
                return value($default);
            }
        }

        return value($target, $params);
    }
}

if (!function_exists('object_get')) {
    /**
     * Get an item from an object using "dot" notation.
     *
     * @param object $object
     * @param string $key
     * @param array $params
     * @param mixed $default
     * @return mixed
     */
    function object_get(object $object, string $key, array $params = [], $default = null)
    {
        if ($key === null || trim($key) === '') {
            return $object;
        }
        foreach (explode('.', $key) as $segment) {
            if (!is_object($object) || !isset($object->{$segment})) {
                return value($default);
            }
            $object = $object->{$segment};
        }
        return value($object, $params);
    }
}

if (!function_exists('last')) {
    /**
     * Get the last element from an array.
     *
     * @param array $array
     * @return mixed
     */
    function last(array $array)
    {
        return end($array);
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     * @param array $params
     * @return mixed
     */
    function value($value, array $params = [])
    {
        return $value instanceof Closure ? $value(...$params) : $value;
    }
}

if (!function_exists('class_basename')) {
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param string|object $class
     * @return string
     */
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('loop')) {
    /**
     * @param callable $handle
     * @param integer $count
     */
    function loop(callable $handle, int $count)
    {
        if ($count > 0) {
            foreach (range(1, $count) as $i) {
                if ($handle($i) === false) {
                    break;
                }
            }
        }
    }
}

if (!function_exists('array_flatten')) {
    /**
     * @param array[] $array
     * @return array
     */
    function array_flatten(array $array)
    {
        $return = [];

        array_walk_recursive($array, static function ($x) use (&$return) {
            $return[] = $x;
        });

        return $return;
    }
}

if (!function_exists('array_some')) {
    /**
     * @param array $array
     * @param callable $fn
     * @return bool
     */
    function array_some(array $array, callable $fn)
    {
        foreach ($array as $value) {
            if ($fn($value)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('array_every')) {
    /**
     * @param array $array
     * @param callable $fn
     * @return bool
     */
    function array_every(array $array, callable $fn)
    {
        foreach ($array as $value) {
            if (!$fn($value)) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('random_color')) {
    function random_color() {
        return sprintf('#%06X', random_int(0, 0xFFFFFF));
    }
}
