<?php
namespace GitChangeLog\Helpers;

use Closure;

class Arrays
{

    /**
     * Retrieves the value of an array element or object property with the given
     * key or property name.
     * If the key does not exist in the array or object, the default value will be
     * returned instead.
     *
     *
     * @param array|object $array
     * @param string|Closure $key
     * @param mixed $default
     * @return mixed the value of the element if found, default value otherwise
     */
    public static function getValue($array, $key, $default = null)
    {
        if ($key instanceof Closure) {
            return $key($array, $default);
        }

        if (is_array($array) && array_key_exists($key, $array)) {
            return $array[$key];
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $array = static::getValue($array, substr($key, 0, $pos), $default);
            $key = substr($key, $pos + 1);
        }

        if (is_object($array)) {
            return isset($array->$key) ? $array->$key : $default;
        } elseif (is_array($array)) {
            return array_key_exists($key, $array) ? $array[$key] : $default;
        } else {
            return $default;
        }
    }

    /**
     * Wrapper method for PHP's in_array function
     *
     * @param mixed $needle
     * @param array $haystack
     * @return boolean
     */
    public static function inArray($needle, $haystack)
    {
        return in_array($needle, $haystack);
    }
}
