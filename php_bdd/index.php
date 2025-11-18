<?php
try {
    $mysqlClient = new PDO(
        'mysql:host=localhost;dbname=jo;charset=utf8',
        'root',
        'root'
    );
} catch (PDOException $e) {
    die($e->getMessage());
}
