<?php require_once $base_path . '/__header.php'; ?>

<? 

$albom_name;
$albom_description;

if(isset($_POST["albom_name"]) && isset($_POST["albom_description"])){
  


  $connection_add = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);

    $albom_name = $_POST["albom_name"];
    $albom_description = $_POST["albom_description"];


    $qry2 = $connection_add -> prepare('INSERT INTO category (id, category, description) VALUES (NULL, :_name, :_description);');
    $qry2 ->bindParam(':_name', $albom_name, PDO::PARAM_STR);
    $qry2 ->bindParam(':_description', $albom_description, PDO::PARAM_STR);

    if($qry2 ->execute()){
        echo "Новый альбом успешно добавлен";
        $connection_add = NULL;
    }
    else{
        echo "Ошибка создания альбома";
    }

    // echo "Запись успешно добавлена";

}
else{
}


?>

<h1>ДОБАВИТЬ АЛЬБОМ</h1>

<form id="new_cat" name="adding" method="POST">

<legend>Название категории</legend>

<input class="input_albom" name="albom_name" type="text">

<br>

<legend>Описание</legend>

<input class="input_albom" name="albom_description" type="text">

<br>

<input type="submit">

</form>

<?php echo "<a href='/'>На главную</a>"; ?>

<?php require_once $base_path . '/__footer.php'; ?>