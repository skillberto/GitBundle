<?php

namespace Skillberto\GitBundle\Util;

class TagPreparatory implements PreparatoryInterface
{
    /**
     * {inheritdoc}
     */
    public function prepare($data)
    {
        $pattern = '/(^v?)(\d+\.\d+(\.\d+){0,2})/';

        preg_match($pattern, $data, $output);

        return $output[2];
    }
}