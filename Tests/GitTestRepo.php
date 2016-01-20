<?php

namespace Skillberto\GitBundle\Tests;

class GitTestRepo
{
    protected $path = null,
        $repository = null,
        $client,
        $fs = null;

    public function __construct()
    {
        $this->path = sys_get_temp_dir().'/testrepo';
        $this->fs = new \Symfony\Component\Filesystem\Filesystem();

        $this->fs->remove($this->path);

        $this->client = new \Gitter\Client();

        $this->repository = $this->client->createRepository($this->path);

        $this->recursiveCommit('randomFile', 10);
    }

    public function commitWithTag($message = null, $tag)
    {
        $this->recursiveCommit($message, 1, $tag);

        return $this;
    }

    public function removeTag($tag)
    {
        $command = 'tag -d '.$tag;

        $this->client->run($this->repository, $command);
    }

    public function getPath()
    {
        return $this->path;
    }

    protected function recursiveCommit($message = null, $count = null, $tag = null)
    {
        if ($count == 0) {
            return;
        }

        $this->createFile();

        $this->repository
            ->addAll()
            ->commit($message);

        if ($tag === null) {
            $tag = $this->createTag($count);
        }

        $this->repository->createTag($tag);

        --$count;

        $this->recursiveCommit($message, $count);
    }

    protected function createFile()
    {
        do {
            $path = $this->path.'/'.rand(0, 500).'.txt';
        } while (file_exists($path));

        $this->fs->dumpFile($path, 'test');
    }

    protected function createTag($count)
    {
        if ($count < 5) {
            $tag = $count.'.'.$count.'.'.$count;
        } else {
            $tag = $count.'.'.$count;
        }

        if ($count % 2 == 0) {
            $tag = 'v'.$tag;
        }

        return  $tag;
    }
}
