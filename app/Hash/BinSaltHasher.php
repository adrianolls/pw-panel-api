<?php

namespace App\Hash;

use Illuminate\Contracts\Hashing\Hasher;
use DB;

/**
 * Description of BinSaltHasher
 *
 * @author Adriano
 */
class BinSaltHasher implements Hasher
{
    /**
     * @param string $hashedValue
     * @return array|string
     */
    public function info($hashedValue)
    {
        return "Binsalt Password hasher";
    }

    public function check($value, $hashedValue, array $options = array())
    {
        $hashedinput = $this->make($value);
        return ($hashedValue === $hashedinput) ? true : false;
    }

    public function make($value, array $options = array())
    {
        return '0x' . md5($value, false);
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }

}
