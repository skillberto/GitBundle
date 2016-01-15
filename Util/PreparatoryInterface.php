<?php

namespace Skillberto\GitBundle\Util;

interface PreparatoryInterface
{
    /**
     * @param  string $data
     * @return string
     */
    public function prepare($data);

    /**
     * @param  string $data
     * @return string
     */
    public function format($data);
}