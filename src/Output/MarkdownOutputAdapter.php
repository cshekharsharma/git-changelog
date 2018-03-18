<?php
namespace GitChangeLog\Output;

use GitChangeLog\Git\CommitMetadata;

class MarkdownOutputAdapter implements OutputAdapterInterface
{

    /**
     * Get markdown formatted changelog text
     *
     * @param CommitMetadata[][] $changelog
     */
    public function getFormattedOutput($changelog)
    {
        $interval = $changelog['interval'];

        $finalOutput = sprintf('## %s  %s', $interval, PHP_EOL);

        $logs = $changelog['logs'];
        foreach ($logs as $type => $commitList) {

            $finalOutput .= sprintf("_**%s:**_  %s", ucwords($type), PHP_EOL);

            if (empty($commitList)) {
                $emptyMsg = sprintf('- _No %s added in this period_ ', $type);
                $finalOutput .= sprintf("%s  %s%s", $emptyMsg, PHP_EOL, PHP_EOL);
            } else {

                foreach ($commitList as $jj => $metadata) {
                    $msg = $metadata->getCommitMessage();
                    $name = $metadata->getAuthorName();
                    $email = $metadata->getAuthorEmail();

                    $line = sprintf("- %s ([%s](mailto:%s))  %s", $msg, $name, $email, PHP_EOL);

                    $finalOutput .= $line;
                }
            }

            $finalOutput .= '  ' . PHP_EOL;
        }

        return $finalOutput;
    }
}
