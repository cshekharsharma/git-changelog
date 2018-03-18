<?php
namespace GitChangeLog\Output;

use GitChangeLog\Constants;

class OutputFactory
{

    private static $map = [
        Constants::OUTPUT_FORMAT_HTML => HtmlOutputAdapter::class,
        Constants::OUTPUT_FORMAT_JSON => JsonOutputAdapter::class,
        Constants::OUTPUT_FORMAT_MARKDOWN => MarkdownOutputAdapter::class,
        Constants::OUTPUT_FORMAT_REMARKUP => RemarkupOutputAdapter::class
    ];

    /**
     * Get output adapter instance
     *
     * @param string $type
     * @return OutputAdapterInterface
     */
    public static function getAdapter($type)
    {
        $adapter = self::$map[Constants::OUTPUT_FORMAT_MARKDOWN];
        if (array_key_exists($type, self::$map)) {
            $adapter = self::$map[$type];
        }

        return new $adapter();
    }
}
