<?php

namespace Skillberto\GitBundle\Twig\Extension;

use Skillberto\GitBundle\Service\GitServiceInterface;

class GitExtension extends \Twig_Extension
{
    protected $gitServiceInterface;

    public function getFunctions()
    {
        return array(
            new \Twig_Function('git_version', array($this->gitServiceInterface, 'getVersion')),
        );
    }

    public function setGitService(GitServiceInterface $gitServiceInterface)
    {
        $this->gitServiceInterface = $gitServiceInterface;
    }

    public function getName()
    {
        return 'git_extension';
    }
}
