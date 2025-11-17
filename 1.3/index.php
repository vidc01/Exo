<?php

function doubleLoop($n) {
    for ($i = 1; $i <= $n; $i++) {
        // Répéter le chiffre i exactement i fois
        for ($j = 1; $j <= $i; $j++) {
            echo $i;
        }
        // Retour à la ligne après chaque séquence
        echo "<br>";
    }
}

// Appel de la fonction avec 5 par défaut si aucune valeur n'est envoyée via POST
doubleLoop($_POST['n'] ?? 5);

?>
