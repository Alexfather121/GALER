<?php require_once $base_path . '/__header.php'; ?>

<?php 

$connection = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);

$res = $connection->query('SELECT category, description FROM category;'); ?>

<table class='block__table'>
        <thead>
            <tr>
                <th>АЛЬБОМ</th>
                <th>ОПИСАНИЕ</th>
            </tr>
        </thead>

        <tbody>


<?php foreach ($res as $result){?>
    <tr>
    <td> 
    <a class="category__link" href="?route=cat&category=<?php echo $result['category']; ?>"> <?php echo strtoupper($result['category']); ?></a></td><td><?php echo $result['description'];?></td></tr>

<?php }

$connection = NULL;
?>

    <tr>
        <td> 
            <a class="category__link" href="/add">ДОБАВИТЬ АЛЬБОМ</a>
        </td>
        <td> 
            +
        </td>
    </tr>

</table>


<?php require_once $base_path . '/__footer.php'; ?>
