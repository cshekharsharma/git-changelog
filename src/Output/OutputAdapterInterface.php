<?php
namespace GitChangeLog\Output;

interface OutputAdapterInterface
{

    public function getFormattedOutput($changelog);
}
