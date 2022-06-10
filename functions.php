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
        foreach ($array as $index => $value) {
            if ($fn($value, $index)) {
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
        if (empty($array)) {
            return false;
        }

        foreach ($array as $value) {
            if (!$fn($value)) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('random_color')) {
    function random_color()
    {
        return sprintf('#%06X', random_int(0, 0xFFFFFF));
    }
}

if (!function_exists('group_split')) {
    function group_split($array, $size)
    {
        $result = [];

        while (count($array)) {
            $result[] = array_splice($array, 0, $size);
        }

        return $result;
    }
}

if (!function_exists('api_result')) {
    /**
     * return array with response to API
     *
     * for `$errors` use an array with api_error()
     *
     * Example:
     *
     * ```php
     * api_result(false,
     *   api_error('example', 'example_1'),
     *   api_error('example_2', ['example_1', 'example_2'])
     * );
     * ```
     *
     * @param bool $result
     * @param array $errors
     * @return array|bool[]
     */
    function api_result(bool $result, ...$errors): array
    {
        if ($result) {
            return ['result' => true];
        }

        return ['result' => false, 'errors' => $errors];
    }
}

if (!function_exists('api_error')) {
    /**
     * return array with errors to be used in `api_result()`
     *
     * @param string $field
     * @param string|array $errors
     * @return array
     */
    function api_error(string $field, $errors): array
    {
        return [
            'field' => $field,
            'msgs' => (array)$errors
        ];
    }
}

if (!function_exists('extension_of')) {
    /**
     * returns file type
     * To be used with FileInput
     * `pluginOptions` => `initialPreviewConfig` => ['type' => extension_of($model->file)]
     *
     * @param $file
     * @return string|null
     */
    function extension_of($file)
    {
        switch ($file) {
            case (bool)preg_match('/(doc|docx)$/i', $file):
            case (bool)preg_match('/(xls|xlsx)$/i', $file):
            case (bool)preg_match('/(ppt|pptx)$/i', $file):
                return 'office';
            case (bool)preg_match('/(zip|rar|tar|gzip|gz|7z)$/i', $file):
                return 'zip';
            case (bool)preg_match('/(pdf)$/i', $file):
                return 'pdf';
            case (bool)preg_match('/(htm|html)$/i', $file):
                return 'htm';
            case (bool)preg_match('/(txt|ini|csv|java|php|js|css)$/i', $file):
                return 'txt';
            case (bool)preg_match('/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i', $file):
                return 'mov';
            case (bool)preg_match('/(mp3|wav)$/i', $file):
                return 'mp3';
            default:
                return 'image';
        }
    }


    if (!function_exists('truncate')) {
        /**
         * @example truncate(-1.49999, 2); // returns -1.49
         * @example truncate(.49999, 3); // returns 0.499
         * @param float $val
         * @param int f
         * @return float
         */
        function truncate($val, $f = 2)
        {
            if (($p = strpos($val, '.')) !== false) {
                $val = floatval(substr($val, 0, $p + 1 + $f));
            }
            return $val;
        }
    }
}
