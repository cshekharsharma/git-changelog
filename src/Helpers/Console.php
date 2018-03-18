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
        if (self::isLinux()) {
            $stdout = Console::execute('which ' . $binary);
        } else {
            $stdout = self::execute('where ' . $binary);
        }

        return $stdout;
    }

    public static function isLinux()
    {
        return DIRECTORY_SEPARATOR === '/';
    }
}
