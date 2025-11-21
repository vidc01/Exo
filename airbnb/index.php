<?php
require 'config.php';

if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
};

if ($page < 1) {
    $page = 1;
};

$limite = 10;
$debut = ($page - 1) * $limite;

if (isset($_GET['tri'])) {
    $tri = $_GET['tri'];
} else {
    $tri = 'name';
};

$colonnes_autorisees = [
    'name' => 'name',
    'ville' => 'neighbourhood_group_cleansed',
    'prix' => 'price',
    'proprietaire' => 'host_name'
];

if (array_key_exists($tri, $colonnes_autorisees)) {
    $colonne_sql = $colonnes_autorisees[$tri];
} else {
    $colonne_sql = 'name';
};

$sql = "SELECT * FROM listings 
        ORDER BY $colonne_sql ASC 
        LIMIT $limite OFFSET $debut";

$stmt = $dbh->query($sql);
$logements = $stmt->fetchAll(PDO::FETCH_ASSOC);
$sqlCount = "SELECT COUNT(*) FROM listings";
$total = $dbh->query($sqlCount)->fetchColumn();
$nb_pages = ceil($total / $limite);

?>

<h1>Site de réservation</h1>

<a href="ajouter.php">Ajouter un résultat</a>
<hr>
<form method="GET">
    <label>Trier par : </label>
    <select name="tri" >
        
        <option value="name" <?php if($tri == 'name') { echo 'selected'; } ?>>Nom</option>
        <option value="ville" <?php if($tri == 'ville') { echo 'selected'; } ?>>Ville</option>
        <option value="prix" <?php if($tri == 'prix') { echo 'selected'; } ?>>Prix</option>
        <option value="proprietaire" <?php if($tri == 'proprietaire') { echo 'selected'; } ?>>Propriétaire</option>
    
    </select>
    <input type="hidden" name="page" value="<?php echo $page; ?>">
    <button type="submit">Trier</button>
</form>
<hr>


<?php foreach ($logements as $l): ?>
    <div style="margin-bottom: 20px;">
        
        <img src="<?php echo htmlspecialchars($l['picture_url']); ?>" alt="Logement" width="200"><br>
        <strong><?php echo htmlspecialchars($l['name']); ?></strong><br>
        Ville : <?php echo htmlspecialchars($l['neighbourhood_group_cleansed']); ?><br>
        Prix : <?php echo htmlspecialchars($l['price']); ?> € / nuit<br>
        Propriétaire : <?php echo htmlspecialchars($l['host_name']); ?><br>
        <hr>
    </div>
<?php endforeach; ?>

<div style="margin-top: 20px;">

    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&tri=<?php echo $tri; ?>">Page précédente</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $nb_pages; $i++): ?> 
        <?php if ($i == $page): ?>
            <span style="color: red; font-weight: bold; margin: 0 5px;"><?php echo $i; ?></span>
        <?php else: ?>
            <a href="?page=<?php echo $i; ?>&tri=<?php echo $tri; ?>" style="margin: 0 5px;"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $nb_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>&tri=<?php echo $tri; ?>">Page suivante</a>
    <?php endif; ?>
</div>