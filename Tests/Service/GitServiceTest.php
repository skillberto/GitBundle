<?php
/**
 * Created by PhpStorm.
 * User: heiszler_n
 * Date: 1/6/2015
 * Time: 3:58 PM
 */

namespace Skillberto\GitBundle\Tests\Service;

use Skillberto\GitBundle\Service\GitService;
use Symfony\Component\Process\Process;

class GitServiceTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        //TODO: create git repo with two branch and commits and tags
    }

    protected function tearDown()
    {
        //TODO: remove git repo
    }

    public function testGetTags()
    {
    }
} 