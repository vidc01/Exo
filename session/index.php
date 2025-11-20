<?php
session_start();
$_SESSION['email'] = $_POST['email'];

echo "<h1>Votre email est : " . $_SESSION['email'] . "</h1>";

?>
<a href="page2.php">Aller à la page 2
 <button onclick = "unset($_SESSION['email'])">Déconnecter</button>
</a>

