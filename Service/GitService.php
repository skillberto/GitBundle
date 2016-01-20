<?php

namespace Skillberto\GitBundle\Service;

use Gitter\Client;
use Skillberto\GitBundle\Exception\InvalidTagException;
use Skillberto\GitBundle\Util\FormatterInterface;
use Skillberto\GitBundle\Validation\ValidatorInterface;

class GitService implements GitServiceInterface
{
    protected $path,
        $validator,
        $formatter;

    public function __construct($path = null, ValidatorInterface $validator, FormatterInterface $formatter)
    {
        $this->path = $path;
        $this->validator = $validator;
        $this->formatter = $formatter;
    }

    /**
     * {inheritdoc}.
     */
    public function getVersion()
    {
        $tag = $this->getLastTag();

        if (!$this->validator->isValid($tag)) {
            throw new InvalidTagException(sprintf("Can't find correct git tag for current version, found: %s", $tag));
        }

        return $this->format($tag);
    }

    /**
     * Get last tag.
     *
     * @return array
     */
    protected function getLastTag()
    {
        $client = new Client();

        $repository = $client->getRepository($this->path);

        return $repository->getLastTag();
    }

    /**
     * Format the tag.
     *
     * @param string $data
     *
     * @return string
     */
    protected function format($data)
    {
        return $this->formatter->format($data);
    }
}
