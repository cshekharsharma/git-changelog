<?php
namespace GitChangeLog;

use GitChangeLog\Git\GitWorker;
use GitChangeLog\Helpers\Arrays;
use GitChangeLog\Output\OutputFactory;
use InvalidArgumentException;
use GitChangeLog\Git\CommitMetadata;

/**
 * Changelog generator
 *
 * @author Chandra Shekhar <shekharsharma705@gmail.com>
 * @since 17-Mar-2018
 */
class ChangeLogGenerator
{

    /**
     * Git working directory of the repository
     *
     * @var string
     */
    private $workingDir;

    /**
     * A valid start date for changelogs
     *
     * @var string
     */
    private $startDate;

    /**
     * A valid end date for changelogs
     *
     * @var string
     */
    private $endDate;

    /**
     * Changelog output format.
     *
     * Valid values are-
     * - json
     * - html
     * - markdown
     * - remarkup
     *
     * @var string
     */
    private $outputFormat;

    /**
     *
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     *
     * @param string $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     *
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     *
     * @param string $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     *
     * @return string
     */
    public function getOutputFormat()
    {
        return $this->outputFormat;
    }

    /**
     *
     * @param string $outputFormat
     */
    public function setOutputFormat($outputFormat)
    {
        $this->outputFormat = $outputFormat;
    }

    /**
     *
     * @return string
     */
    public function getWorkingDir()
    {
        return $this->workingDir;
    }

    /**
     *
     * @param string $workingDir
     */
    public function setWorkingDir($workingDir)
    {
        $this->workingDir = $workingDir;
    }

    /**
     * Generate changelogs.
     *
     * This is the entrypoint of the application.
     *
     * @return array
     */
    public function generate()
    {
        $this->verifyInputParameters();

        $worker = new GitWorker();
        $worker->setWorkingDirectory($this->getWorkingDir());
        $worker->validateEnvironment();

        $history = $worker->getHistory($this->getStartDate(), $this->getEndDate());

        $changelogs = $this->prepareChangeLogs($history);

        $outputAdapter = OutputFactory::getAdapter($this->getOutputFormat());
        $output = $outputAdapter->getFormattedOutput($changelogs);

        return [
            'format' => $this->getOutputFormat(),
            'changelogs' => $output
        ];
    }

    /**
     * Prepare and format changelogs
     *
     * @param CommitMetadata[] $history
     * @return array
     */
    public function prepareChangeLogs($history)
    {
        $from = date('d-M-Y', strtotime($this->getStartDate()));
        $to = date('d-M-Y', strtotime($this->getEndDate()));

        $interval = sprintf("[%s - %s]", $from, $to);

        $changelog = [
            'interval' => $interval,
            'logs' => [
                Constants::COMMIT_TYPE_FEATURE => [],
                Constants::COMMIT_TYPE_BUGFIX => [],
                Constants::COMMIT_TYPE_GENERAL => [],
                Constants::COMMIT_TYPE_SECURITY => []
            ]
        ];

        if (empty($history)) {
            return $changelog;
        }

        foreach ($history as $ii => $commit) {
            $message = $commit->getCommitMessage();
            list ($type, $message) = $this->getCommitMessageType($message);

            if ($commit->getCommitTimestamp() > strtotime($this->getStartDate())) {

                $virtualCommit = clone $commit;
                $virtualCommit->setCommitMessage($message);

                $changelog['logs'][$type][] = $virtualCommit;
            }
        }

        return $changelog;
    }

    /**
     * Extract correct commit type by parsing commit message
     *
     * @param string $message
     * @return array
     */
    public function getCommitMessageType($message)
    {
        $type = Constants::COMMIT_TYPE_GENERAL;
        $components = explode(":", $message, 2);

        if (count($components) < 2) {
            return [
                $type,
                $message
            ];
        }

        array_map('trim', $components);

        $possibleType = current($components);
        $predefinedTypes = [
            Constants::COMMIT_TYPE_BUGFIX,
            Constants::COMMIT_TYPE_FEATURE,
            Constants::COMMIT_TYPE_SECURITY,
            Constants::COMMIT_TYPE_GENERAL
        ];

        if (Arrays::inArray(strtolower($possibleType), $predefinedTypes)) {
            $type = $possibleType;
            $message = end($components);
        }

        return [
            $type,
            $message
        ];
    }

    /**
     * Verify if valid input params are provided or not.
     *
     * @throws InvalidArgumentException
     */
    public function verifyInputParameters()
    {
        if (empty($this->getStartDate())) {
            throw new InvalidArgumentException("Start date is not defined for changelogs.");
        }

        if (empty($this->getEndDate())) {
            throw new InvalidArgumentException("End date is not defined for changelogs.");
        }

        if (empty($this->getOutputFormat())) {
            throw new InvalidArgumentException("Output format is not defined for changelogs.");
        }
    }
}
