<?php

namespace Skillberto\GitBundle\Validation;

interface ValidatorInterface
{
    /**
     * Return true if input is valid
     *
     * @param  mixed $data
     * @return boolean
     */
    public function isValid($data);
}