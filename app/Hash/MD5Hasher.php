<?php

namespace App\Hash;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class MD5Hasher implements HasherContract
{

    /**
     * @param string $hashedValue
     * @return array|string
     */
    public function info($hashedValue)
    {
        return "0xMD5 Password hasher";
    }

    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param array $options
     * @return string
     * @internal param bool $output
     */
    public function make( $value, array $options = [] )
    {
        return '0x' . md5( $value );
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return $this->make($value) === $hashedValue;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
