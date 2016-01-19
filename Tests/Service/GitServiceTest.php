<?php

namespace Skillberto\GitBundle\Tests\Service;

use Gitter\Client;
use Gitter\Repository;
use Skillberto\GitBundle\Service\GitService;
use Symfony\Component\Filesystem\Filesystem;

class GitServiceTest extends \PHPUnit_Framework_TestCase
{
    protected
        $path,
        $repository,
        $count,
        $fs;

    protected function setUp()
    {
        $this->path = __DIR__."/testrepo";

        $this->fs = new Filesystem();

        if ($this->fs->exists($this->path)) {
            return;
        }

        $client = new Client();
        $this->repository = $client->createRepository($this->path);

        $this->recursiveCommit(1);
    }

    protected function recursiveCommit($count = null)
    {
        if ($count === null)
        {
            $count = $this->count;
        }

        if ($count > 10) {
            return;
        }

        $this->fs->dumpFile($this->path.'/'.rand(0, 500).'.txt', 'test');

        $this->repository
            ->addAll()
            ->commit("randomFile");

        if ($count < 5) {
            $tag = $count.".".$count.".".$count;
        } else {
            $tag = $count.".".$count;
        }

        if ($count % 2) {
            $tag = "v". $tag;
        }

        $this->repository->createTag($tag);

        $count++;

        $this->count = $count;

        $this->recursiveCommit();
    }

    /*protected function tearDown()
    {
        $this->fs->remove($this->path);
    }*/

    public function testGetValidVersion()
    {
        $service = $this->getService(true);

        $this->assertEquals(10.10, $service->getVersion());
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
        $mock = $this->getMockBuilder('Skillberto\GitBundle\Util\FormatterInterface', array('format'))->getMock();
        $mock
            ->expects($this->any())
            ->method('format')
            ->will($this->returnArgument(0));

        return $mock;
    }

    protected function getService($valid = true)
    {
        $validator = $this->getValidator($valid);
        $formatter = $this->getFormatter();

        return new GitService($this->path, $validator, $formatter);
    }
} 