<?php

namespace Skillberto\GitBundle\Util;

class TagPreparatory implements PreparatoryInterface
{
    const PIECES = 3;

    /**
     * {inheritdoc}
     */
    public function prepare($data)
    {
        $pieces = explode('.', $data);
        $count = count($pieces);
        $tag = implode('', $pieces);

        while ($count <= self::PIECES) {
            $tag .= '0';
            $count++;
        }

        return $tag;

        //todo: canonicaze data 
    }

    /**
     * {inheritdoc}
     */
    public function format($data)
    {
        return ltrim($data, 'v');
    }
}