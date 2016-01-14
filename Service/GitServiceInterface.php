<?php
/**
 * Created by PhpStorm.
 * User: heiszler_n
 * Date: 1/6/2015
 * Time: 12:52 PM
 */

namespace Skillberto\GitBundle\Service;

use Skillberto\GitBundle\Exception\InvalidTagException;


interface GitServiceInterface {

    /**
     * Get actual Git version if available
     *
     * @return string|void
     * @throws InvalidTagException
     * @throws \RuntimeException
     */
    public function getVersion();

    /**
     * Set Git Repository path
     *
     * @param  null $path
     * @return GitServiceInterface
     */
    public function setPath($path = null);
} 