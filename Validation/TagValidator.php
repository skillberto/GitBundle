<?php

namespace Skillberto\GitBundle\Validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class TagValidator implements ValidatorInterface
{
    /**
     * {inheritdoc}
     */
    public function isValid($data)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection(array(
            "tag" => array(
                new Assert\NotNull(),
                new Assert\NotBlank(),
                new Assert\Type(array('type' => 'string')),
                new Assert\Regex(array('pattern' => '/(^v?)\d+\.\d+(\.\d+)?$/'))
            )
        ));

        if (count($validator->validate(array("tag" => $data), $constraint)) > 0) {
            return false;
        }

        return true;
    }
}