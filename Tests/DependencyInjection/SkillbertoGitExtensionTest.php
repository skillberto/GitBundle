<?php

namespace Skillberto\GitBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Skillberto\GitBundle\DependencyInjection\SkillbertoGitExtension;

class SkillbertoGitExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return array(
            new SkillbertoGitExtension()
        );
    }

    public function testWithoutPath()
    {
        $dir = __DIR__.'/../Resources/testrepo/a';

        $this->container->setParameter('kernel.root_dir', $dir);

        $this->load();

        $this->assertContainerBuilderHasParameter('skillberto.git_tag.path', $this->container->getParameter('kernel.root_dir').'/../');
    }

    public function testWithPath()
    {
        $path = __DIR__.'/../Resources/testrepo';

        $this->load(array('repo_path' => $path));

        $this->assertContainerBuilderHasParameter('skillberto.git_tag.path', $path);
    }
}