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

class GitService implements GitServiceInterface
{
    protected $path;

    /**
     * {inheritdoc}
     */
    public function getVersion()
    {
        $tag = $this->getLastTag();

        if (!$this->validate($tag)) {
            throw new InvalidTagException(sprintf("Can't find correct git tag for current version, found: ", $tag));
        }

        return $tag;
    }

    /**
     * {inheritdoc}
     */
    public function setPath($path = null)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get tag for version
     *
     * @return string
     */
    protected function getLastTag()
    {
        return $this->getTags()[0];
    }

    protected function getTags()
    {
        $client = new Client();

        $repository = $client->getRepository($this->path);

        return $repository->getTags();
    }

    /**
     * Validate data for version controlling
     *
     * @param  string $data
     * @return bool
     */
    protected function validate($data)
    {
        if (! is_string($data) || empty($data)) {
            return false;
        }

        $tag = $this->stripTag($data);

        if ($tag === null) {
            return false;
        }

        if (count(explode('.', $data)) != count(explode('.', $tag))) {
            return false;
        }

        return true;
    }

    /**
     * Strip tag from string
     *
     * @param  string $data
     * @return string|null
     */
    protected function stripTag($data)
    {
        $pattern = '/(^v?)(\d+\.\d+(\.\d+){0,2})/';

        preg_match($pattern, $data, $output);

        return isset($output[2]) ? $output[2] : null;
    }
} 