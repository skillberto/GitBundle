<?php

namespace Skillberto\GitBundle\Util;

class TagPreparatory implements PreparatoryInterface
{
    /**
     * {inheritdoc}
     */
    public function prepare($data)
    {
        return ltrim($data, 'v');
    }
}