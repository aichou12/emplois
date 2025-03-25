<?php

// Définir les valeurs récupérées depuis la base de données
$plainText = 'Eurf22fx'; // Remplace par le mot de passe correct
$storedHash = 'juHbaRMF1WrTqn0yI6KScFYIVOi2fYwgXzXmBtT++omdun1o1j8upCoLMpxvkegLUO4qUU6BjeKQAEqNTFKzMg==';
$salt = 'nCwPmJ4SCV9A2t7sS9/hhqngVIhjxDe45evwYjoI9/0'; // Peut être en base64 ou brut

// Fonctions utilitaires
function tryHash($plainText, $salt, $storedHash, $length, $decodeSalt = false) {
    // Décoder le salt si nécessaire
    if ($decodeSalt) {
        $salt = base64_decode($salt);
    }

    // Générer le hash avec PBKDF2-SHA512
    $rawBinary = hash_pbkdf2('sha512', $plainText, $salt, 5000, $length, true);
    $computedHash = base64_encode($rawBinary);

    // Vérifier si ça correspond
    $match = hash_equals($storedHash, $computedHash);

    // Affichage des résultats
    echo "Test avec " . ($decodeSalt ? "Base64 Salt" : "Raw Salt") . " et longueur $length : ";
    echo $match ? "✅ MATCH ✅" : "❌ Échec ❌";
    echo "\nComputed Hash : $computedHash\n";
    echo "Stored Hash   : $storedHash\n\n";

    return $match;
}

// Tester toutes les combinaisons possibles
echo "=== Début des tests ===\n\n";

$found = false;
foreach ([40, 64] as $length) {
    foreach ([false, true] as $decodeSalt) {
        if (tryHash($plainText, $salt, $storedHash, $length, $decodeSalt)) {
            $found = true;
        }
    }
}

if ($found) {
    echo "🎉 Une correspondance a été trouvée !\n";
} else {
    echo "🚨 Aucune correspondance trouvée. Vérifiez le mot de passe et le salt !\n";
}

echo "\n=== Fin des tests ===\n";

?>
