<?php

namespace App\Services;

class PasswordService
{
    /**
     * Reproduit le hash Symfony 3 (MessageDigestPasswordEncoder)
     * sha512, base64, salt, 5000 itérations.
     *
     * @param string $plainPassword Le mot de passe en clair fourni par l'utilisateur
     * @param string $salt          Le salt récupéré dans votre table (ex: "nCwPmJ4SCV9A...")
     * @return string               Le hash final encodé en base64
     */
    public function hashSymfony3Password(string $plainPassword, string $salt): string
    {
        $iterations = 5000;
        $algorithm  = 'sha512';
        $merged     = $plainPassword.'{'.$salt.'}';

        $digest = hash($algorithm, $merged, true);

        for ($i = 1; $i < $iterations; ++$i) {
            $digest = hash($algorithm, $digest.$merged, true);
        }

        return base64_encode($digest);
    }
}
