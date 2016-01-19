<?php

require_once __DIR__.'/../vendor/autoload.php';

class InitRepo
{
    protected
        $path,
        $repository,
        $fs;

    public function __construct()
    {
        $this->path = $_SERVER['TEST_REPO'];
        $this->fs   = new \Symfony\Component\Filesystem\Filesystem();
    }

    public function init()
    {
        if ($this->fs->exists($this->path)) {
            return;
        }

        $client = new \Gitter\Client();
        $this->repository = $client->createRepository($this->path);

        $this->recursiveCommit(1);
    }

    protected function recursiveCommit($count = null)
    {
        if ($count === null)
        {
            $count = $this->count;
        }

        if ($count > 10) {
            return;
        }

        $this->fs->dumpFile($this->path.'/'.rand(0, 500).'.txt', 'test');

        $this->repository
            ->addAll()
            ->commit("randomFile");

        if ($count < 5) {
            $tag = $count.".".$count.".".$count;
        } else {
            $tag = $count.".".$count;
        }

        if ($count % 2 == 0) {
            $tag = "v". $tag;
        }

        $this->repository->createTag($tag);

        $count++;

        $this->count = $count;

        $this->recursiveCommit();
    }
}

$c = new InitRepo();
$c->init();
