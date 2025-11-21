<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css"> 
</head>
<body>
<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$titre = $_POST['name'];
$ville = $_POST['neighbourhood_group_cleansed'];
$prix = $_POST['price'];
$proprio = $_POST['host_name'];
$image = $_POST['picture_url'];
$sql = "INSERT INTO listings (name, neighbourhood_group_cleansed, price, host_name, picture_url)
VALUES (?, ?, ?, ?, ?)";
$stmt = $dbh->prepare($sql);
$stmt -> execute([$titre, $ville, $prix, $proprio, $image]);
echo "<div class='message success'>Annonce ajoutée avec succès !</div>"; 
echo "<div style='text-align:center;'><a href='index.php'>Retour à la liste</a></div>";
}
?>
<h1>Ajouter un résultat :</h1>
<form method="post">
<label>Nom du logement :</label><br>
<input type="text" name="name" required><br><br>
<label>Ville :</label><br>
<input type="text" name="neighbourhood_group_cleansed" required><br><br>
<label>Prix (€) :</label><br>
<input type="number" name="price" required><br><br>
<label>Nom du propriétaire :</label><br>
<input type="text" name="host_name" required><br><br>
<label>URL de l'image :</label><br>
<input type="text" name="picture_url" required><br><br>
<button type="submit">Ajouter</button>
</form>

<footer>
<p>© Site de réservation de Carlos et Victor.</p>
</footer>

</body>
</html>