<?php
namespace GitChangeLog\Output;

use GitChangeLog\Helpers\Json;
use GitChangeLog\Git\CommitMetadata;

class JsonOutputAdapter implements OutputAdapterInterface
{

    /**
     * Get JSON formatted changelog text
     *
     * @param CommitMetadata[][] $changelog
     */
    public function getFormattedOutput($changelog)
    {
        $innerChangelog = [];

        $logs = $changelog['logs'];
        foreach ($logs as $type => $commitList) {
            if (empty($commitList)) {
                $innerChangelog[$type] = [];
            } else {
                foreach ($commitList as $ii => $metadata) {
                    $innerChangelog[$type][$ii] = $metadata->toDictionary();
                }
            }
        }

        $formattedoutput = [
            $changelog['interval'] => $innerChangelog
        ];

        return Json::encode($formattedoutput);
    }
}
