<?php

$n = 5;
function doubleLoop($n) {

    for ($i = 1; $i <= $n; $i++) {

        // Cette boucle va répéter le chiffre i exactement i fois
        for ($j = 1; $j <= $i; $j++) {
            echo $i;
        }

        // Retour à la ligne après chaque séquence
        echo "<br>";
    }

}

doubleLoop($n);