<?php
/**
 * Created by PhpStorm.
 * User: heiszler_n
 * Date: 1/6/2015
 * Time: 12:47 PM
 */

namespace Skillberto\GitBundle\Service;

use Gitter\Client;
use Skillberto\GitBundle\Exception\InvalidTagException;
use Skillberto\GitBundle\Validation\ValidatorInterface;

class GitService implements GitServiceInterface
{
    protected
        $path,
        $validator;

    public function __construct($path = null, ValidatorInterface $validator)
    {
        $this->path = $path;
        $this->validator = $validator;
    }

    /**
     * {inheritdoc}
     */
    public function getVersion()
    {
        $tag = $this->getLastTag();

        if (! $this->validator->isValid($tag)) {
            throw new InvalidTagException(sprintf("Can't find correct git tag for current version, found: ", $tag));
        }

        return $tag;
    }

    /**
     * Get last tag
     *
     * @return string
     */
    protected function getLastTag()
    {
        return $this->getTags()[0];
    }

    /**
     * Get tags
     *
     * @return array
     */
    protected function getTags()
    {
        $client = new Client();

        $repository = $client->getRepository($this->path);

        return $repository->getTags();
    }
} 