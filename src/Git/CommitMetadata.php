<?php
namespace GitChangeLog\Git;

/**
 * Commit metadata component class
 *
 * @author Chandra Shekhar Sharma <shekharsharma705@gmail.com>
 * @since 15-Mar-2018
 */
class CommitMetadata
{

    private $commitHash;

    private $authorEmail;

    private $authorName;

    private $commitTimestamp;

    private $commitMessage;

    public function __construct($hash, $email, $name, $timestamp, $message)
    {
        $this->commitHash = $hash;
        $this->authorEmail = $email;
        $this->authorName = $name;
        $this->commitTimestamp = $timestamp;
        $this->commitMessage = $message;
    }

    /**
     *
     * @return string
     */
    public function getCommitHash()
    {
        return $this->commitHash;
    }

    /**
     *
     * @param string $commitHash
     */
    public function setCommitHash($commitHash)
    {
        $this->commitHash = $commitHash;
    }

    /**
     *
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     *
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     *
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     *
     * @return string
     */
    public function getCommitTimestamp()
    {
        return $this->commitTimestamp;
    }

    /**
     *
     * @param string $commitTimestamp
     */
    public function setCommitTimestamp($commitTimestamp)
    {
        $this->commitTimestamp = $commitTimestamp;
    }

    /**
     *
     * @return string
     */
    public function getCommitMessage()
    {
        return $this->commitMessage;
    }

    /**
     *
     * @param string $commitMessage
     */
    public function setCommitMessage($commitMessage)
    {
        $this->commitMessage = $commitMessage;
    }

    /**
     * Convert object to array
     *
     * @return string[]
     */
    public function toDictionary()
    {
        return [
            'commitHash' => $this->getCommitHash(),
            'authorName' => $this->getAuthorName(),
            'authorEmail' => $this->getAuthorEmail(),
            'commitTimestamp' => $this->getCommitTimestamp(),
            'commitMessage' => $this->getCommitMessage()
        ];
    }
}
