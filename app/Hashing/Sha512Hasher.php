<?php
namespace App\Hashing;

use Illuminate\Contracts\Hashing\Hasher;

class Sha512Hasher implements Hasher
{
    public function make($value, array $options = [])
    {
        return hash('sha512', $value);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        return hash('sha512', $value) === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false; // SHA-512 ne nécessite pas de rehashing
    }
}
