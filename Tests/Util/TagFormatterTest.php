<?php


namespace Skillberto\GitBundle\Tests\Util;

use Skillberto\GitBundle\Util\TagFormatter;

class TagFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testPreparation()
    {
        $formatter = new TagFormatter();

        $this->assertEquals('1.0',   $formatter->format('1.0'));
        $this->assertEquals('1.0.2', $formatter->format('1.0.2'));
        $this->assertEquals('1.0',   $formatter->format('v1.0'));
        $this->assertEquals('1.0.0', $formatter->format('v1.0.0'));
    }
}