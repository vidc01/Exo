<?php
$eleves = [
    "Alice" => [15, 12, 14],
    "Bob" => [10, 14, 12],
    "Claire" => [18, 17, 19]
]; 
function calcule($tableau) {
    return array_sum($tableau) / count($tableau);
}
foreach ($eleves as $nom => $notes) {
    $moyenne = calcule($notes);
    echo "Nom : $nom - Moyenne : $moyenne <br>";
}
 