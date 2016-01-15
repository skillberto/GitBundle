<?php

namespace Skillberto\GitBundle\Service;

use Gitter\Client;
use Skillberto\GitBundle\Exception\InvalidTagException;
use Skillberto\GitBundle\Util\PreparatoryInterface;
use Skillberto\GitBundle\Validation\ValidatorInterface;

class GitService implements GitServiceInterface
{
    protected
        $path,
        $validator,
        $preparatory;

    public function __construct($path = null, ValidatorInterface $validator, PreparatoryInterface $preparatory)
    {
        $this->path = $path;
        $this->validator = $validator;
        $this->preparatory = $preparatory;
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

        return $this->preparatory->prepare($tag);
    }

    /**
     * Get last tag
     *
     * @return string
     */
    protected function getLastTag()
    {
        return array_pop($this->getTags());
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