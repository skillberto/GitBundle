<?php


namespace Skillberto\GitBundle\Tests\Util;


use Skillberto\GitBundle\Util\TagPreparatory;

class TagPreparatoryTest extends \PHPUnit_Framework_TestCase
{
    public function testPreparation()
    {
        $preparatory = new TagPreparatory();

        $this->assertEquals('1.0', $preparatory->prepare('1.0'));
        $this->assertEquals('1.0.2', $preparatory->prepare('1.0.2'));
        $this->assertEquals('1.0', $preparatory->prepare('v1.0'));
        $this->assertEquals('1.0.0', $preparatory->prepare('v1.0.0'));
    }
}