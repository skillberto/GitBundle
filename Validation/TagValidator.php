<?php
/**
 * Created by PhpStorm.
 * User: heiszler_n
 * Date: 2016.01.14.
 * Time: 16:49
 */

namespace Skillberto\GitBundle\Validation;


class TagValidator implements ValidatorInterface
{

    /**
     * Validate data for version controlling
     *
     * @param  string $data
     * @return bool
     */
    public function isValid($data)
    {
        if (! is_string($data) || empty($data)) {
            return false;
        }

        $tag = $this->stripTag($data);

        if ($tag === null) {
            return false;
        }

        if (count(explode('.', $data)) != count(explode('.', $tag))) {
            return false;
        }

        return true;
    }

    /**
     * Strip tag from string
     *
     * @param  string $data
     * @return string|null
     */
    protected function stripTag($data)
    {
        $pattern = '/(^v?)(\d+\.\d+(\.\d+){0,2})/';

        preg_match($pattern, $data, $output);

        return isset($output[2]) ? $output[2] : null;
    }
}