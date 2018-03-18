<?php
namespace GitChangeLog\Output;

use GitChangeLog\Git\CommitMetadata;

class HtmlOutputAdapter implements OutputAdapterInterface
{

    /**
     * Get Html formatted changelog text
     *
     * @param CommitMetadata[][] $changelog
     */
    public function getFormattedOutput($changelog)
    {
        $interval = $changelog['interval'];
        $finalOutput = sprintf('<h3>%s</h3>', $interval);

        $logs = $changelog['logs'];
        foreach ($logs as $type => $commitList) {

            $finalOutput .= sprintf("<b><i>%s:</i></b><ul>", ucwords($type));

            if (empty($commitList)) {
                $emptyMsg = sprintf('<li><i>No %s added in this period</i></li>', $type);
                $finalOutput .= sprintf("%s", $emptyMsg);
            } else {
                foreach ($commitList as $jj => $metadata) {
                    $msg = $metadata->getCommitMessage();
                    $name = $metadata->getAuthorName();
                    $email = $metadata->getAuthorEmail();

                    $printformat = '<li>%s (<a target="_blank" href="mailto:%s">%s</a>)</li>';
                    $line = sprintf($printformat, $msg, $email, $name);

                    $finalOutput .= $line;
                }
            }

            $finalOutput .= '</ul><br>';
        }

        return $finalOutput;
    }
}
