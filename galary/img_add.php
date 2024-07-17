<?php require_once $base_path . '/__header.php'; ?>

<?php 

//&& in_array(pathinfo($_FILES["img_name"]['name'], PATHINFO_EXTENSION),$EXTENTIONS)

$category = $_GET['category'];

$EXTENTIONS = ['gif','jpg','jpeg','jpe','png','svg'];

$count = 0; //количество Файлов в папке

$img_descr = '';

if(isset($_FILES["img_name"]) && isset($_POST["img_description"]) && in_array(pathinfo($_FILES["img_name"]['name'], PATHINFO_EXTENSION),$EXTENTIONS)){
    
    $img_descr = $_POST["img_description"];

    if(!file_exists($category)){
        mkdir($category);
    }
    
    $files = scandir($category); //просматриваем папку с категорией
    
    $files = array_diff($files, ['..', '.']);
    
    foreach($files as $file){ //проходим по массиву
      
           $count++;
        }
    $dest_path = $category. "/" . $category . "_" . ++$count . '.' . pathinfo($_FILES["img_name"]['name'], PATHINFO_EXTENSION);

    move_uploaded_file($_FILES["img_name"]['tmp_name'], $dest_path);

    $info = pathinfo($dest_path);

    $path_img = $info['dirname'] . "/" . $info['filename'] . "." . $info['extension'];

    $connection_add = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);

    $res = $connection_add->query("SELECT id FROM category WHERE category = '$category';"); //Узнаем категорию, в которой надо сохранить картинку

    foreach ($res as $result){

    $ident = $result['id'];
}

    $qry2 = $connection_add -> prepare("INSERT INTO `img` (`id`, `img_num`, `img_desc`, `link`, `like`, `dislike`) VALUES (:_cat, NULL, :_description, :_link, '0', '0');");
    $qry2 ->bindParam(':_cat', $ident, PDO::PARAM_STR);
    $qry2 ->bindParam(':_description', $img_descr, PDO::PARAM_STR);
    $qry2 ->bindParam(':_link', $path_img, PDO::PARAM_STR);

    if($qry2 ->execute()){
        echo "Фото добавлено в альбом";
        $connection_add = NULL;
 ?> <a class="back_btn" href='?route=cat&category=<?php echo $category; ?>'>Перейти в Альбом</a>
        <?php
    }
     

    }

      else{

        echo "Необходимо заполнить все поля";

    }

?>

<h1>ДОБАВИТЬ ФОТО</h1>

<form enctype="multipart/form-data" name="adding_photo" method="post">

<legend>Выберите файл</legend>

<input class="input_albom" name="img_name" type="file">

<br>

<legend>Название фото</legend>

<input class="input_albom" name="img_description" type="text">

<br>

<input type="submit">

</form>

<a class="back_btn" href='/'>На главную</a>

<?php require_once $base_path . '/__footer.php'; ?>