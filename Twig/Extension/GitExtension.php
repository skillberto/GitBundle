<?php
/**
 * Created by PhpStorm.
 * User: pentalab_2
 * Date: 2015.01.06.
 * Time: 20:44
 */

namespace Skillberto\GitBundle\Twig\Extension;

use Skillberto\GitBundle\Service\GitServiceInterface;

class GitExtension extends \Twig_Extension
{
    protected
        $gitServiceInterface;

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction("git_version", array($this->gitServiceInterface, 'getVersion'))
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