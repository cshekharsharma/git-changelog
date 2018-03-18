<?php
use PHPUnit\Framework\TestCase;
use GitChangeLog\ChangeLogGenerator;

class ChangeLogTest extends TestCase
{

    public function setUp()
    {}

    public function testChangeLogGeneration()
    {
        $generator = new ChangeLogGenerator();

        $generator->setStartDate(date('Y-m-d', strtotime('-1 month')));
        $generator->setEndDate(date('Y-m-d', time()));
        $generator->setWorkingDir(dirname(dirname(__FILE__)));
        $generator->setOutputFormat('json');

        $changelogs = $generator->generate();
        $this->assertTrue(is_array($changelogs));
        $this->assertTrue(isset($changelogs['changelogs']));
        $this->assertTrue(isset($changelogs['format']));
    }
}
