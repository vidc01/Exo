<?php
session_start();
try {
    $dbh = new PDO('mysql:host=localhost;dbname=jo;charset=utf8', 'root', 'root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
?>

<h1>Inscription</h1>
<form method="post" action="./">
    <label> Username : </label>
    <input type="text" name="username" required><br/>
    <label> Password : </label>
    <input type="password" name="password" required><br/>
    <input type="submit" value="S'inscrire" name="register">
</form>
<?php
if (isset($_POST['register'])) {
    if (empty($_POST['username'])) {
        echo "<b>Erreur : Le champ username de l'inscription est vide.</b><br/>"; 
    } elseif (empty($_POST['password'])) {
        echo "<b>Erreur : Le champ password de l'inscription est vide.</b><br/>"; 
    } else {

        $check = $dbh->prepare("SELECT * FROM user WHERE username = :username"); 
        $check->execute(['username' => $_POST['username']]); 
        if ($check->rowCount() > 0) { 
            echo "<b>Erreur : Le username existe déjà dans la base de données.</b><br/>"; 
        } else {
           
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sth = $dbh->prepare('INSERT INTO `user` (`username`, `password`) VALUES (:username, :password)');
            $sth->execute([
                'username' => $_POST['username'],
                'password' => $hash,
            ]);
            echo "<b>Votre inscription est valide</b>";
            echo '<form method="post" action="">
        <input type="hidden" name="username_to_delete" value="' . htmlspecialchars($_POST['username']) . '">
        <input type="submit" name="delete_user" value="Supprimer cet utilisateur">
      </form>';

        }
    }
}
if (isset($_POST['delete_user'])) {
    $sth = $dbh->prepare("DELETE FROM user WHERE username = :username");
    $sth->execute(['username' => $_POST['username_to_delete']]);
    echo "<b>L'utilisateur " . htmlspecialchars($_POST['username_to_delete']) . " a été supprimé.</b><br/>";
}

?>

<h1>Connexion</h1>
<form method="post" action="./">
    <label> Username : </label>
    <input type="text" name="username" required><br/>
    <label> Password : </label>
    <input type="password" name="password" required><br/>
    <input type="submit" value="Se connecter" name="connect">
</form>
<?php
if (isset($_POST['connect'])) {
    
    if (empty($_POST['username'])) {
        echo "<b>Erreur : Le champ username de la connexion est vide.</b><br/>"; 
    } elseif (empty($_POST['password'])) {
        echo "<b>Erreur : Le champ password de la connexion est vide.</b><br/>";
    } else {
        
        $stmt = $dbh->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $_POST['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            echo "<b>Erreur : Le username n'existe pas dans la base de données.</b><br/>"; 
        } elseif (!password_verify($_POST['password'], $user['password'])) {
            echo "<b>Erreur : Le mot de passe est invalide.</b><br/>"; 
        } else {
            $_SESSION['username'] = $_POST['username'];
            echo "<b>Vous êtes connecté.</b><br/>"; 
        }
    }
}
?>
<?php

$query=$dbh->prepare("SELECT * FROM user");
$query->execute();
 
$data=$query->fetchAll();
//var_dump($data);
echo "<h2>Liste des utilisateurs enregistrés :</h2>";
foreach($data as $row){
    echo " - ".htmlspecialchars($row['username'])."<br/>";
}
?>