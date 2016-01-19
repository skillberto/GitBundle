<?php

require_once __DIR__.'/../vendor/autoload.php';

class InitRepo
{
    protected
        $path = null,
        $repository = null,
        $client = null,
        $fs = null;

    public function __construct($path = null)
    {
        if ($path === null) {
            $this->path = $_SERVER['TEST_REPO'];
        } else {
            $this->path = $path;
        }

        $this->fs = new \Symfony\Component\Filesystem\Filesystem();
        $this->client = new \Gitter\Client();


        if ($this->fs->exists($this->path)) {
            $this->repository = $this->client->getRepository($this->path);
        } else {
            $this->init();
        }
    }

    public function init()
    {
        if ($this->fs->exists($this->path)) {
            return $this;
        }

        $this->repository = $this->client->createRepository($this->path);

        $this->recursiveCommit("randomFile", 10);

        return $this;
    }

    public function commitWithTag($message = null, $tag)
    {
        $this->recursiveCommit($message, 1, $tag);

        return $this;
    }

    public function removeTag($tag)
    {
        $command = "tag -d ".$tag;

        $client = $this->repository->getClient();
        $client->run($this->repository, $command);
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

        $count--;

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
            $tag = $count.".".$count.".".$count;
        } else {
            $tag = $count.".".$count;
        }

        if ($count % 2 == 0) {
            $tag = "v". $tag;
        }

        return  $tag;
    }
}

$c = new InitRepo();
$c->init();
