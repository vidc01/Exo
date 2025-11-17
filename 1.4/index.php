<?php

function pgcd_1($a, $b) {
    $a = abs($a); 
    $b = abs($b);
    
    if ($a == 0) return $b;
    if ($b == 0) return $a;

    while ($a != $b) {
        if ($a > $b) {
            $a = $a - $b;
        } else {
            $b = $b - $a;
        }
    }
    return $a;
}

function pgcd_2($a, $b) {
    $a = abs($a);
    $b = abs($b);

    while ($b > 0) {
        $reste = $a % $b;
        $a = $b;
        $b = $reste;
    }
    return $a;
}

function pgcd_3($a, $b) {
    $a = abs($a);
    $b = abs($b);

    if ($b == 0) {
        return $a;
    } else {
        return pgcd_3($b, $a % $b);
    }
}

$nombre1 = 21;
$nombre2 = 14;

echo "<h3>Résultats pour $nombre1 et $nombre2 :</h3>";

echo "Méthode avec la soustraction : " . pgcd_1($nombre1, $nombre2) . " <br>";
echo "Méthode avec la division euclidienne : " . pgcd_2($nombre1, $nombre2) . " <br>";
echo "Méthode avec la recursivité : " . pgcd_3($nombre1, $nombre2) . " <br>";

?>