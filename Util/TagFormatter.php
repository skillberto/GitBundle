<?php

namespace Skillberto\GitBundle\Util;

class TagFormatter implements FormatterInterface
{
    /**
     * {inheritdoc}.
     */
    public function format($data)
    {
        return ltrim($data, 'v');
    }
}
