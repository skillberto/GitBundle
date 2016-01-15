<?php

namespace Skillberto\GitBundle\Validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class TagValidator implements ValidatorInterface
{
    /*
     * {inheritdoc}
     */
    public function isValid($data)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection(array(
            new Assert\NotNull(),
            new Assert\Type(array('type' => 'string')),
            new Assert\Regex(array('pattern' => '(^v?)(\d+\.\d+(\.\d+){0,2}'))
        ));

        if (count($validator->validate($data, $constraint)) > 0) {
            return false;
        }

        return true;
    }
}