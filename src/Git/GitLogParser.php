<?php
namespace GitChangeLog\Git;

use GitChangeLog\Constants;

/**
 * Git log parser
 *
 * @author Chandra Shekhar Sharma <shekharsharma705@gmail.com>
 * @since 15-Mar-2018
 */
class GitLogParser
{

    /**
     * Parse git log history
     *
     * @param string $history
     * @return NULL|\GitChangeLog\Git\CommitMetadata[]
     */
    public function parseHistory($history)
    {
        $commitList = $this->getCommitListFromHistory($history);

        if (count($commitList) === 0) {
            return null;
        }

        $parsedHistory = [];
        foreach ($commitList as $ii => $line) {
            if ($line === null || $line === '') {
                continue;
            }

            $metadata = $this->getCommitMetadata($line);
            $parsedHistory[] = $metadata;
        }

        return $parsedHistory;
    }

    /**
     * Git list of commits from the history blob.
     *
     * @param string $history
     * @return array
     */
    public function getCommitListFromHistory($history)
    {
        return explode(PHP_EOL, trim($history));
    }

    /**
     * Parse each line of commit history and returns metadata info.
     *
     * @param string $line
     * @return \GitChangeLog\Git\CommitMetadata
     */
    public function getCommitMetadata($line)
    {
        $components = explode(Constants::COMMIT_ELEM_SEPARATOR, $line, 5);
        list ($hash, $email, $name, $timestamp, $message) = $components;

        return new CommitMetadata($hash, $email, $name, $timestamp, $message);
    }
}
