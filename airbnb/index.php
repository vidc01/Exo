<link rel="stylesheet" href="style.css">
<?php
require 'config.php';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limite = 10;
$debut = ($page - 1) * $limite;
$tri = isset($_GET['tri']) ? $_GET['tri'] : 'name';
 
$colonnes_autorisees = [
    'name' => 'name',
    'ville' => 'neighbourhood_group_cleansed',
    'prix' => 'price',
    'proprietaire' => 'host_name'
];
$colonne_sql = $colonnes_autorisees[$tri] ?? 'name';
 
$sql = "SELECT * FROM listings ORDER BY $colonne_sql ASC LIMIT $limite OFFSET $debut";
$stmt = $dbh->query($sql);
$logements = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
$sqlCount = "SELECT COUNT(*) FROM listings";
$total = $dbh->query($sqlCount)->fetchColumn();
$nb_pages = ceil($total / $limite);
?>
 
<h1>Notre site de réservation</h1>
<a href="ajouter.php">Ajouter un résultat</a>
<hr>
 
<form method="GET">
    <label>Trier par : </label>
    <select name="tri">
        <option value="name" <?php if($tri === 'name') echo 'selected'; ?>>Nom</option>
        <option value="ville" <?php if($tri === 'ville') echo 'selected'; ?>>Ville</option>
        <option value="prix" <?php if($tri === 'prix') echo 'selected'; ?>>Prix</option>
        <option value="proprietaire" <?php if($tri === 'proprietaire') echo 'selected'; ?>>Propriétaire</option>
    </select>
    <input type="hidden" name="page" value="<?php echo $page; ?>">
    <button type="submit">Trier</button>
</form>
<hr>
 
<?php foreach ($logements as $l): ?>
    <div class="logement">
        <?php if (!empty($l['picture_url'])): ?>
            <img class="logement-image" src="<?php echo htmlspecialchars($l['picture_url']); ?>" alt="Logement indisponible">
        <?php else: ?>
            <div class="pas-de-photo logement-image">Pas de photo</div>
        <?php endif; ?>
 
        <div class="logement-details">
            <strong><?php echo htmlspecialchars($l['name']); ?></strong><br>
            Ville : <?php echo htmlspecialchars($l['neighbourhood_group_cleansed']); ?><br>
            Prix : <?php echo htmlspecialchars($l['price']); ?> € / nuit<br>
            Propriétaire : <?php echo htmlspecialchars($l['host_name']); ?><br>
        </div>
 
        <div class="proprietaire-image">
            <?php if (!empty($l['host_thumbnail_url'])): ?>
                <img src="<?php echo htmlspecialchars($l['host_thumbnail_url']); ?>" alt="Photo propriétaire">
            <?php else: ?>
                <div class="pas-de-photo">Pas de photo</div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
 
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&tri=<?php echo $tri; ?>">Page précédente</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $nb_pages; $i++): ?>
        <?php if ($i === $page): ?>
            <span class="page-active"><?php echo $i; ?></span>
        <?php else: ?>
            <a href="?page=<?php echo $i; ?>&tri=<?php echo $tri; ?>" class="page-link"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $nb_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>&tri=<?php echo $tri; ?>">Page suivante</a>
    <?php endif; ?>
</div>
 
<footer>
    <p>© Site de réservation de Carlos et Victor.</p>
</footer>