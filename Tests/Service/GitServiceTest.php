<?php

namespace Skillberto\GitBundle\Tests\Service;

use Skillberto\GitBundle\Service\GitService;
use Skillberto\GitBundle\Util\TagFormatter;
use Skillberto\GitBundle\Validation\TagValidator;

class GitServiceTest extends \PHPUnit_Framework_TestCase
{
    protected
        $repo = null;

    protected function tearDown()
    {
        if ($this->repo !== null) {
            $this->repo->removeTag("v1.3.5.2");
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
        $this->repo = new \InitRepo();
        $this->repo->commitWithTag("invalidRepo", "v1.3.5.2");

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

        return new GitService($_SERVER['TEST_REPO'], $validator, $formatter);
    }
} 