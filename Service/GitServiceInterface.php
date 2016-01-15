<?php

namespace Skillberto\GitBundle\Service;

use Skillberto\GitBundle\Exception\InvalidTagException;
use Skillberto\GitBundle\Util\PreparatoryInterface;
use Skillberto\GitBundle\Validation\ValidatorInterface;


interface GitServiceInterface
{
    /**
     * Construct GitService
     *
     * @param string                $path
     * @param ValidatorInterface    $validator
     * @param PreparatoryInterface  $preparatory
     */
    public function __construct($path = null, ValidatorInterface $validator, PreparatoryInterface $preparatory);

    /**
     * Get actual Git version if available
     *
     * @return string|void
     * @throws InvalidTagException
     * @throws \RuntimeException
     */
    public function getVersion();
} 