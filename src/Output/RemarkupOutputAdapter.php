<?php
namespace GitChangeLog\Output;

use GitChangeLog\Git\CommitMetadata;

class RemarkupOutputAdapter implements OutputAdapterInterface
{

    /**
     * Get Remarkup formatted changelog text.
     *
     * Remarkup is a follow-up document language to markdown or wiki-markup.
     * This is used by Phabricator.
     *
     * @param CommitMetadata[][] $changelog
     */
    public function getFormattedOutput($changelog)
    {
        $interval = $changelog['interval'];

        $finalOutput = sprintf('===%s===  %s', $interval, PHP_EOL);

        $logs = $changelog['logs'];
        foreach ($logs as $type => $commitList) {

            $finalOutput .= sprintf("//**%s:**//  %s", ucwords($type), PHP_EOL);

            if (empty($commitList)) {
                $emptyMsg = sprintf('- //No %s added in this period// ', $type);
                $finalOutput .= sprintf("%s  %s%s", $emptyMsg, PHP_EOL, PHP_EOL);
            } else {
                foreach ($commitList as $jj => $metadata) {
                    $msg = $metadata->getCommitMessage();
                    $name = $metadata->getAuthorName();
                    $email = $metadata->getAuthorEmail();

                    $line = sprintf("- %s ([[mailto:%s | %s]])  %s", $msg, $email, $name, PHP_EOL);

                    $finalOutput .= $line;
                }
            }

            $finalOutput .= '  ' . PHP_EOL;
        }

        return $finalOutput;
    }
}
