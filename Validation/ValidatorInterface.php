<?php
/**
 * Created by PhpStorm.
 * User: heiszler_n
 * Date: 2016.01.14.
 * Time: 16:47
 */

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