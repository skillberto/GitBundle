<?php

namespace Skillberto\GitBundle\Util;

interface PreparatoryInterface
{
    /**
     * @param  string $data
     * @return string
     */
    public function prepare($data);
}