<?php

namespace Skillberto\GitBundle\Tests\Service;

use Skillberto\GitBundle\Service\GitService;
use Skillberto\GitBundle\Tests\GitTestRepo;
use Skillberto\GitBundle\Util\TagFormatter;
use Skillberto\GitBundle\Validation\TagValidator;

class GitServiceTest extends \PHPUnit_Framework_TestCase
{
    protected static
        $git = null,
        $remove = false;

    public static function setUpBeforeClass()
    {
        self::$git = new GitTestRepo();
    }

    protected function tearDown()
    {
        if (self::$remove === true) {
            self::$git->removeTag("v1.3.5.2");
        }
    }

    public function testGetValidVersion()
    {
        $service = $this->getService(true);

        $this->assertEquals("1.1.1", $service->getVersion());
    }

    /**
     * @expectedException \Skillberto\GitBundle\Exception\InvalidTagException
     */
    public function testGetInvalidVersion()
    {
        self::$git->commitWithTag("invalidRepo", "v1.3.5.2");
        self::$remove = true;

        $service = $this->getService();

        $service->getVersion();
    }

    protected function getValidator()
    {
        return new TagValidator();
    }

    protected function getFormatter()
    {
        return new TagFormatter();
    }

    protected function getService()
    {
        $validator = $this->getValidator();
        $formatter = $this->getFormatter();

        return new GitService(self::$git->getPath(), $validator, $formatter);
    }
} 