<?php

namespace Skillberto\GitBundle\Service;

use Skillberto\GitBundle\Exception\InvalidTagException;
use Skillberto\GitBundle\Util\FormatterInterface;
use Skillberto\GitBundle\Validation\ValidatorInterface;


interface GitServiceInterface
{
    /**
     * Construct GitService
     *
     * @param string              $path
     * @param ValidatorInterface  $validator
     * @param FormatterInterface  $formatter
     */
    public function __construct($path = null, ValidatorInterface $validator, FormatterInterface $formatter);

    /**
     * Get actual Git version if available
     *
     * @return string|void
     * @throws InvalidTagException
     * @throws \RuntimeException
     */
    public function getVersion();
} 