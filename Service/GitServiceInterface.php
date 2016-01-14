<?php
/**
 * Created by PhpStorm.
 * User: heiszler_n
 * Date: 1/6/2015
 * Time: 12:52 PM
 */

namespace Skillberto\GitBundle\Service;

use Skillberto\GitBundle\Exception\InvalidTagException;
use Skillberto\GitBundle\Validation\ValidatorInterface;


interface GitServiceInterface
{
    /**
     * @param mixed $path
     * @param ValidatorInterface $validator
     */
    public function __construct($path = null, ValidatorInterface $validator);

    /**
     * Get actual Git version if available
     *
     * @return string|void
     * @throws InvalidTagException
     * @throws \RuntimeException
     */
    public function getVersion();
} 