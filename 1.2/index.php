<?php
$max = 100;

function fooBar($max) {
    for ($i = 1; $i <= $max; $i++) {

        if ($i % 3 === 0 && $i % 5 === 0) {
            echo "FooBar<br>";
        } elseif ($i % 3 === 0) {
            echo "Foo<br>";
        } elseif ($i % 5 === 0) {
            echo "Bar<br>";
        } else {
            echo $i . "<br>";
        }

    }
}

fooBar($max);

?>
