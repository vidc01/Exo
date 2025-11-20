<?php
try {
    $dbh = new PDO('mysql:host=localhost;dbname=jo;charset=utf8', 'root', 'root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
?>


<h1>Inscription</h1>
<form method=post action="./">
    <label> Username : </label>
    <input type="text" name="username" required><br/>

    <label> Password : </label>
    <input type="password" name="password" required><br/>

    <input type="submit" value="S'inscrire" name="register">
</form>




<?php
if (isset($_POST['register'])) {
    if ($_POST['username'] != '' && $_POST['password'] != '') {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sth = $dbh->prepare('INSERT INTO `user` (`username`, `password`) VALUES (:username, :password)');
        $sth->execute([
            'username' => $_POST['username'],
            'password' => $hash,
        ]);
        echo "<b>Votre inscription est valide</b>";
    }
} 
