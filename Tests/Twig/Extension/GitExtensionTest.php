<?php

namespace Skillberto\GitBundle\Tests\Twig\Extension;

use Skillberto\GitBundle\Twig\Extension\GitExtension;

class GitExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testGitVersion()
    {
        $this->assertEquals('1.1.1', $this->getTemplate('{{git_version()}}')->render(array()));
    }

    protected function getTemplate($template)
    {
        $extension = new GitExtension();
        $extension->setGitService($this->getService());

        $loader = new \Twig_Loader_Array(array('index' => $template));
        $twig = new \Twig_Environment($loader, array('debug' => true, 'cache' => false));
        $twig->addExtension($extension);

        return $twig->loadTemplate('index');
    }

    protected function getService()
    {
        $mock = $this
            ->getMockBuilder('\Skillberto\GitBundle\Service\GitServiceInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mock
            ->expects($this->any())
            ->method('getVersion')
            ->will($this->returnValue('1.1.1'));

        return $mock;
    }
}
