<?php
namespace GitChangeLog\Git;

use Exception;
use GitChangeLog\Helpers\Console;
use GitChangeLog\Constants;

/**
 * Git worker
 *
 * @author Chandra Shekhar <shekharsharma705@gmail.com>
 * @since 16-Mar-2018
 */
class GitWorker
{

    private $workingDirectory;

    /**
     *
     * @return mixed
     */
    public function getWorkingDirectory()
    {
        return $this->workingDirectory;
    }

    /**
     *
     * @param mixed $workingDirectory
     */
    public function setWorkingDirectory($workingDirectory)
    {
        if ($workingDirectory === null) {
            $workingDirectory = getcwd();
        }

        $this->workingDirectory = $workingDirectory;
        chdir($this->getWorkingDirectory());
    }

    public function validateEnvironment()
    {
        if (! $this->getGitBinaryPath()) {
            throw new Exception("Git binary does not exist.");
        }

        if (! Console::execute('git rev-parse --is-inside-work-tree') == 'true') {
            throw new Exception('Current directory is not a valid GIT working tree.');
        }

        return true;
    }

    public function getHistory($after, $before)
    {
        $format = $this->getHistoryFormat();

        $gitBinary = $this->getGitBinaryPath();

        $rawCommand = '%s log --after="%s" --before=%s --no-merges --pretty=format:%s';
        $command = sprintf($rawCommand, $gitBinary, $after, $before, $format);
        $rawHistory = Console::execute($command);

        if (empty($rawHistory)) {
            return null;
        }

        $parser = new GitLogParser();
        return $parser->parseHistory($rawHistory);
    }

    public function getHistoryFormat()
    {
        $elements = array(
            Constants::FORMAT_COMMIT_HASH,
            Constants::FORMAT_AUTHOR_EMAIL,
            Constants::FORMAT_AUTHOR_NAME,
            Constants::FORMAT_COMMIT_TIMESTAMP,
            Constants::FORMAT_COMMIT_MESSAGE
        );

        $separator = Constants::COMMIT_ELEM_SEPARATOR;
        $format = implode($separator, $elements);

        return $format;
    }

    public function getGitBinaryPath()
    {
        return Console::resolveBinary('git');
    }
}
