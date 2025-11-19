<?php
try {
    $mysqlClient =  new PDO(
        'mysql:host=localhost;dbname=jo;charset=utf8',
        'root',
        'root'
    );
} catch (PDOException $e) {
    die($e->getMessage());
}

$sort = "nom";
if (isset($_GET['sort'])){
    $sort = $_GET['sort'];
}

$order = "desc";

if (isset($_GET['order'])){
    $order = $_GET['order'];
}


$query = $mysqlClient->prepare('select * from jo.`100` ORDER BY '.$sort . ' ' . $order);
$query->execute();

$data = $query->fetchAll();

$temp = 0;

function changeorder($token) {
    global $temp;
    if($token=='Nom'){
        $sort = "nom";
    }
    if($token=='Pays'){
        $sort = "nom";
    }
    if($token=='Course'){
        $sort = "nom";
    }
    if($token=='Temps'){
        $sort = "nom";
    }
    $temp++;
}

$mysqlClient = null;
$dbh = null;
?>
<?php $toggle = ($order === 'ASC') ? 'DESC' : 'ASC'; ?>
<table>
    <thead>
        <tr>
            <th>
                <a href="?sort=nom&order=<?php echo ($sort === 'nom') ? $toggle : 'ASC'; ?>">Nom
                    <span class="arrow up <?php echo ($sort==='nom' && strtolower($order)==='asc')? 'active' : ''; ?>">▲</span>
                    <span class="arrow down <?php echo ($sort==='nom' && strtolower($order)==='desc')? 'active' : ''; ?>">▼</span>
                </a>
            </th>
            <th>
                <a href="?sort=pays&order=<?php echo ($sort === 'pays') ? $toggle : 'ASC'; ?>">Pays
                    <span class="arrow up <?php echo ($sort==='pays' && strtolower($order)==='asc')? 'active' : ''; ?>">▲</span>
                    <span class="arrow down <?php echo ($sort==='pays' && strtolower($order)==='desc')? 'active' : ''; ?>">▼</span>
                </a>
            </th>
            <th>
                <a href="?sort=course&order=<?php echo ($sort === 'course') ? $toggle : 'ASC'; ?>">Course
                    <span class="arrow up <?php echo ($sort==='course' && strtolower($order)==='asc')? 'active' : ''; ?>">▲</span>
                    <span class="arrow down <?php echo ($sort==='course' && strtolower($order)==='desc')? 'active' : ''; ?>">▼</span>
                </a>
            </th>
            <th>
                <a href="?sort=temps&order=<?php echo ($sort === 'temps') ? $toggle : 'ASC'; ?>">Temps
                    <span class="arrow up <?php echo ($sort==='temps' && strtolower($order)==='asc')? 'active' : ''; ?>">▲</span>
                    <span class="arrow down <?php echo ($sort==='temps' && strtolower($order)==='desc')? 'active' : ''; ?>">▼</span>
                </a>
            </th>
        </tr>
    </thead>
<?php foreach($data as $value) { ?>
    <tr>
        <td><?php echo $value["nom"]; ?></td>
        <td><?php echo $value["pays"]; ?></td>
        <td><?php echo $value["course"]; ?></td>
        <td><?php echo $value["temps"]; ?></td>
    </tr>
<?php }  ?>
</table>
<style>.arrow.active{color:red!important} th a{ text-decoration:none; color:black; }</style>

