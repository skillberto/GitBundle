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
        $fs;

    protected function setUp()
    {
        $this->path = __DIR__."/testrepo";

        $this->fs = new Filesystem();

        $client = new Client();
        $repository = $client->createRepository($this->path);

        $this->recursiveCommit($repository, 1);
    }

    protected function recursiveCommit(Repository $repository, $count)
    {
        if ($count > 10) {
            return;
        }

        $this->fs->dumpFile($this->path.'/'.rand(0, 500).'.txt', 'test');

        $repository
            ->addAll()
            ->commit("randomFile");

        if ($count < 5) {
            $repository->createTag($count.".".$count.".".$count);
        } else {
            $repository->createTag($count.".".$count);
        }

        $count++;

        $this->recursiveCommit($repository, $count);
    }

    protected function tearDown()
    {
        $this->fs->remove($this->path);
    }

    public function testGetCurrentVersion()
    {
        $validator = $this->getValidator(true);
        $preparatory = $this->getPreparatory();

        $service = new GitService($this->path, $validator, $preparatory);

        $this->assertEquals(10, $service->getVersion());
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

    protected function getPreparatory()
    {
        $mock = $this->getMockBuilder('Skillberto\GitBundle\Util\PreparatoryInterface', array('prepare'))->getMock();
        $mock
            ->expects($this->any())
            ->method('prepare')
            ->will($this->returnArgument(0));

        return $mock;
    }
} 