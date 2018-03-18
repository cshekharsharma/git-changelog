<?php
namespace GitChangeLog\Helpers;

use stdClass;
use Exception;
use JsonSerializable;

/**
 * Helper class for JSON encoding and decoding.
 * This is a concrete implementation of JSON standards
 */
class Json
{

    /**
     * Encodes the given value into a JSON string.
     * The method enhances `json_encode()` by supporting JavaScript expressions.
     * In particular, the method will not encode a JavaScript expression that is
     * represented in terms of a [[JsExpression]] object.
     *
     * @param mixed $value
     *            the data to be encoded
     * @param integer $options
     *            the encoding options. For more det ails please refer to
     *            <http://www.php.net/manual/en/function.json-encode.php>. Default is `JSON_UNESCAPED_SLASHES |
     *            JSON_UNESCAPED_UNICODE`.
     * @return string the encoding result
     */
    public static function encode($value, $options = 352)
    {
        $expressions = [];
        $value = static::processData($value, $expressions, uniqid());

        $json = json_encode($value, $options);
        self::checkJsonLastError(json_last_error());

        return empty($expressions) ? $json : strtr($json, $expressions);
    }

    /**
     * Decodes the given JSON string into a PHP data structure.
     *
     * @param string $json
     *            the JSON string to be decoded
     * @param boolean $asArray
     *            whether to return objects in terms of associative arrays.
     * @return mixed the PHP data
     * @throws Exception if there is any decoding error
     */
    public static function decode($json, $asArray = true)
    {
        if (is_array($json)) {
            throw new Exception('Invalid JSON data.');
        }

        $decode = json_decode((string) $json, $asArray);
        self::checkJsonLastError(json_last_error());

        return $decode;
    }

    /**
     * Checks if there is any error in last json encoding or decoding
     *
     * @throws Exception if there is any
     */
    private static function checkJsonLastError($jsonLastError)
    {
        switch ($jsonLastError) {
            case JSON_ERROR_NONE:
                break;
            case JSON_ERROR_DEPTH:
                throw new Exception('The maximum stack depth has been exceeded.');
            case JSON_ERROR_CTRL_CHAR:
                throw new Exception('Control character error, possibly incorrectly encoded.');
            case JSON_ERROR_SYNTAX:
                throw new Exception('Syntax error.');
            case JSON_ERROR_STATE_MISMATCH:
                throw new Exception('Invalid or malformed JSON.');
            case JSON_ERROR_UTF8:
                throw new Exception('Malformed UTF-8 characters, possibly incorrectly encoded.');
            case JSON_ERROR_RECURSION:
                throw new Exception('One or more recursive references in the value to be encoded');
            case JSON_ERROR_INF_OR_NAN:
                throw new Exception('One or more NAN or INF values in the value to be encoded');
            case JSON_ERROR_UNSUPPORTED_TYPE:
                throw new Exception('A value of a type that cannot be encoded was given');
            default:
                throw new Exception('Unknown JSON decoding error.');
        }
    }

    /**
     * Pre-processes the data before sending it to `json_encode()`.
     *
     * @param mixed $data
     *            the data to be processed
     * @param array $expressions
     *            collection of JavaScript expressions
     * @param string $expPrefix
     *            a prefix internally used to handle JS expressions
     * @return mixed the processed data
     */
    protected static function processData($data, &$expressions, $expPrefix)
    {
        if (is_object($data)) {
            if ($data instanceof JsonSerializable) {
                $data = $data->jsonSerialize();
            } else {
                $result = [];
                foreach ($data as $name => $value) {
                    $result[$name] = $value;
                }
                $data = $result;
            }

            if ($data === []) {
                return new stdClass();
            }
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $data[$key] = static::processData($value, $expressions, $expPrefix);
                }
            }
        }

        return $data;
    }

    /**
     * To check if a string is in json format or not
     *
     * @param mixed $string
     * @return boolean
     */
    public static function isJSON($string)
    {
        return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string, true))))) ? true : false;
    }
}
