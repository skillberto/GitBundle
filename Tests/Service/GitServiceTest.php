<?php

namespace Skillberto\GitBundle\Tests\Service;

use Skillberto\GitBundle\Service\GitService;
use Skillberto\GitBundle\Util\TagFormatter;

class GitServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValidVersion()
    {
        $service = $this->getService(true);

        $this->assertEquals("10.10", $service->getVersion());
    }

    /**
     * @expectedException \Skillberto\GitBundle\Exception\InvalidTagException
     */
    public function testGetInvalidVersion()
    {
        $service = $this->getService(false);

        $service->getVersion();
    }

    protected function getValidator($isValid)
    {
        $mock = $this
            ->getMockBuilder('Skillberto\GitBundle\Validation\ValidatorInterface', array('isValid'))
            ->getMock();

        $mock
            ->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue($isValid));

        return $mock;
    }

    protected function getFormatter()
    {
        return new TagFormatter();
    }

    protected function getService($valid = true)
    {
        $validator = $this->getValidator($valid);
        $formatter = $this->getFormatter();

        return new GitService($_SERVER['TEST_REPO'], $validator, $formatter);
    }
} 