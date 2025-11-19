<?php
try {
   
    $connexionBaseDeDonnees= new PDO('mysql:host=localhost;dbname=jo', 'root', 'root');
    $connexionBaseDeDonnees->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
 
    if (isset($_POST['nom_coureur'])) {
        $nomCoureur = $_POST['nom_coureur'];
        $paysCoureur = strtoupper($_POST['pays_coureur']);
        $nomCourse = $_POST['nom_course'];
        $tempsCoureur = $_POST['temps_coureur'];
 
        if (strlen($paysCoureur) == 3 && is_numeric($tempsCoureur)) {
            $requeteInsertion = $connexionBaseDeDonnees->prepare("INSERT INTO `100` (nom, pays, course, temps) VALUES (:nom, :pays, :course, :temps)");
            $requeteInsertion->execute([
                'nom' => $nomCoureur,
                'pays' => $paysCoureur,
                'course' => $nomCourse,
                'temps' => $tempsCoureur
            ]);
            echo "<p>Coureur ajouté avec succès !</p>";
        } else {
            echo "<p>Erreur : Le pays doit avoir 3 lettres et le temps doit être un nombre.</p>";
        }
    }
 
    $numeroPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $nombreResultatsParPage = 10;
    $debutPagination = ($numeroPage - 1) * $nombreResultatsParPage;
 
    $termeRecherche = isset($_GET['terme_recherche']) ? $_GET['terme_recherche'] : '';
    if ($termeRecherche) {
        $requeteSelection = $connexionBaseDeDonnees->prepare("SELECT * FROM `100` WHERE nom LIKE :terme_recherche OR pays LIKE :terme_recherche OR course LIKE :terme_recherche LIMIT $debutPagination, $nombreResultatsParPage");
        $requeteSelection->execute(['terme_recherche' => "%$termeRecherche%"]);
        $listeCoureurs = $requeteSelection->fetchAll();
    } else {
        $requeteSelection = $connexionBaseDeDonnees->query("SELECT * FROM `100` LIMIT $debutPagination, $nombreResultatsParPage");
        $listeCoureurs = $requeteSelection->fetchAll();
    }
 
    $requeteCompteTotal = $termeRecherche ?
        $connexionBaseDeDonnees->prepare("SELECT COUNT(*) FROM `100` WHERE nom LIKE :terme_recherche OR pays LIKE :terme_recherche OR course LIKE :terme_recherche") :
        $connexionBaseDeDonnees->query("SELECT COUNT(*) FROM `100`");
 
    if ($termeRecherche) {
        $requeteCompteTotal->execute(['terme_recherche' => "%$termeRecherche%"]);
        $nombreTotalCoureurs = $requeteCompteTotal->fetchColumn();
    } else {
        $nombreTotalCoureurs = $requeteCompteTotal->fetchColumn();
    }
 
    $nombreTotalPages = ceil($nombreTotalCoureurs / $nombreResultatsParPage);
 
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
 
 
 
<h1>Ajouter un coureur</h1>
<form method="post">
    Nom : <input type="text" name="nom_coureur" required><br>
    Pays (3 lettres) : <input type="text" name="pays_coureur" maxlength="3" required><br>
    Course : <input type="text" name="nom_course" required><br>
    Temps : <input type="number" name="temps_coureur" required><br>
    <input type="submit" value="Ajouter">
</form>
 
<h2>Rechercher un coureur</h2>
<form method="get">
    <input type="text" name="terme_recherche" placeholder="Rechercher..." value="<?php echo isset($termeRecherche) ? $termeRecherche : ''; ?>">
    <input type="submit" value="Rechercher">
</form>
 
<h2>Liste des coureurs</h2>
<table border="1">
    <tr>
        <th>Nom</th>
        <th>Pays</th>
        <th>Course</th>
        <th>Temps</th>
    </tr>
    <?php if (isset($listeCoureurs)) foreach ($listeCoureurs as $coureur) : ?>
    <tr>
        <td><?php echo $coureur['nom']; ?></td>
        <td><?php echo $coureur['pays']; ?></td>
        <td><?php echo $coureur['course']; ?></td>
        <td><?php echo $coureur['temps']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
 
<div class="pagination">
    <?php if (isset($nombreTotalPages)) for ($i = 1; $i <= $nombreTotalPages; $i++) : ?>
        <a href="?page=<?php echo $i; ?><?php if (isset($termeRecherche) && $termeRecherche) echo '&terme_recherche=' . urlencode($termeRecherche); ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</div>
 