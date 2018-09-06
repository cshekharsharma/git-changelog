<?php
namespace GitChangeLog\Helpers;

class Console
{

    public static function execute($command)
    {
        $escapedCommand = escapeshellcmd((string) trim($command));
        return trim(shell_exec($escapedCommand));
    }

    public static function resolveBinary($binary)
    {
        $stdout = null;
        if (self::isWindows()) {
            $stdout = self::execute(sprintf('where %s', $binary));
        } else {
            $stdout = self::execute(sprintf('which %s', $binary));
        }

        return $stdout;
    }

    public static function isLinux()
    {
        return DIRECTORY_SEPARATOR === '/';
    }

    public static function isWindows()
    {
        return DIRECTORY_SEPARATOR !== '/';
    }

}
