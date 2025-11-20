<?php
session_start();
if (!empty($_POST['email'])) {
    $_SESSION['email'] = $_POST['email'];
}?>
<h1>Ton email est : 
    <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Non défini'; ?>
</h1>

<a href="traitement.php">
    <button>Retour</button>
</a><br><br>

