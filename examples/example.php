<?php
use GitChangeLog\Constants;

require_once '../vendor/autoload.php';

$generator = new \GitChangeLog\ChangeLogGenerator();

$generator->setStartDate('2018-01-01');
$generator->setEndDate('2018-04-01');
$generator->setWorkingDir(dirname(dirname(__FILE__)));

$generator->setOutputFormat(Constants::OUTPUT_FORMAT_REMARKUP);
print_r($generator->generate());

$generator->setOutputFormat(Constants::OUTPUT_FORMAT_MARKDOWN);
print_r($generator->generate());

$generator->setOutputFormat(Constants::OUTPUT_FORMAT_HTML);
print_r($generator->generate());

$generator->setOutputFormat(Constants::OUTPUT_FORMAT_JSON);
print_r($generator->generate());
