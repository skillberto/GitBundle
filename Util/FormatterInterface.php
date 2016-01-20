<?php

namespace Skillberto\GitBundle\Util;

interface FormatterInterface
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function format($data);
}
