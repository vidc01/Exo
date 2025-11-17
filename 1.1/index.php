<?php


function school($age){
    if ($age <= 3) {
        echo "creche";
    } elseif ($age <= 6) {
        echo "maternelle";
    } elseif ($age <= 11) {
        echo "primaire";
    } elseif ($age <= 16) {
        echo "collège";
    } elseif ($age <= 18) {
        echo "lycée";
    } else {
        echo null;
    }
}       
school($_POST['age']);
