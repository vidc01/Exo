<?php
$host = 'localhost';
$dbname = 'airbnb';
$user = 'root';
$pass = 'root';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>