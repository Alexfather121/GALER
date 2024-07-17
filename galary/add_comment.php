<?php require_once $base_path . '/__header.php'; ?>

<? 

$id_photo = $_GET['img_id'];

$category = $_GET['category'];

if(isset($_POST["comment"])){
  
  $connection_add = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);

    $qry2 = $connection_add -> prepare("INSERT INTO `comment` (`img_num`, `comment`) VALUES (:_id, :_com);");
    $qry2 ->bindParam(':_id', $id_photo, PDO::PARAM_STR);
    $qry2 ->bindParam(':_com', $_POST["comment"], PDO::PARAM_STR);

    if($qry2 ->execute()){
        echo "Новый комментарий успешно добавлен";
        $connection_add = NULL;
    }
    else{
        echo "Ошибка создания комментария";
    }

}
else{
}

if(isset($_POST["delete_com"])){

    $comnum = $_POST["delete_com"];

    $connect = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);
    
      $qry3 = $connect-> exec("DELETE FROM `comment` WHERE `comment`.`comment_num` = $comnum;");

        if($qry3){
          echo "Новый комментарий успешно удален";
          $connection_add = NULL;
      }
      else{
          echo "Ошибка удаления комментария";
      }
  
  }
  else{
  }

?>

<h1>ДОБАВИТЬ КОММЕНТАРИЙ</h1>

<?php 

$connection = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);

$result_photo = $connection->query("SELECT * FROM img WHERE img_num = '$id_photo';"); 

foreach ($result_photo as $res){
?>

<div class="photo_item" id="<?php echo $id_photo ?>">
<a href="<?php echo $res['link'] ?>"><img src="<?php echo $res['link'] ?>" ></a>
<span class="description_image"><?php echo $res['img_desc'] ?></span>
<div class="like_dislike">
<div class="like"><a href=""><img class="like_img" src="img/like.svg"></a>
<span class="span_like"><?php echo $res['like'] ?></span>
</div>
<div class="dislike"><a href=""><img class="dis_like_img" src="img/like.svg"></a>
<span class="span_dislike"><?php echo $res['dislike'] ?></span>
</div>
</div>

</div>

<?php } $connection = NULL ?>

<?php 

$connection = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);

$result_photo = $connection->query("SELECT * FROM comment WHERE img_num = '$id_photo';"); 

foreach ($result_photo as $res_com){?>


<span class="comment_item" id="<?php echo $res_com['comment_num'] ?>"><div><?php echo $res_com['comment'] ?></div><form id="delete" method="POST"><input type="submit" value="удалить"><input class="hid" name="delete_com" type="text" value="<?php echo $res_com['comment_num']?>"></form></span>

<?php }

?>


<form id="new_com" name="adding_com" method="POST">

<legend>Комментарий</legend>

<input class="input_albom" name="comment" type="text">


<input type="submit">

</form>

<a class='btn' href='/?route=cat&category=<?php echo $category ?>'>Назад</a>

<a class='btn' href='/'>На главную</a>

<div class="modal">
        <img src="" alt="">
    </div>

<?php require_once $base_path . '/__footer.php'; ?>

    <script>
    let modal_wind = document.querySelector('.modal');
    let img_for_click = document.querySelectorAll('.photo_item > a');
    let body = document.getElementsByTagName('body')[0];
    let link='';
    let ph_it = document.querySelectorAll('.photo_item')[0];


        for(i=0; i<(img_for_click.length); i++){

            img_for_click[i].addEventListener('click', work_w);

        }

      function work_w(e){
        modal_wind.classList.add('active');

        e.preventDefault();

        if(e.target.tagName == "A"){

            link = e.target.firstElementChild.getAttribute('src');

        }

        else{

            link = e.target.getAttribute('src');

        }

        modal_wind.firstElementChild.setAttribute('src',link);

      }

      modal_wind.addEventListener('click', (e)=>{
      modal_wind.classList.remove('active');
      });


      function analiz(evt){

        if(sessionStorage.getItem(ph_it.firstElementChild.getAttribute('href'))=='0'){
            return;
        }

        if(sessionStorage.getItem(ph_it.firstElementChild.getAttribute('href'))=='-1'){
       ph_it.firstElementChild.nextElementSibling.nextElementSibling.children[1].children[0].nextElementSibling.innerText = ph_it.firstElementChild.nextElementSibling.nextElementSibling.children[1].children[0].nextElementSibling.innerText * 1 + 1;
       ph_it.firstElementChild.nextElementSibling.nextElementSibling.children[1].children[0].children[0].classList.add('active');
    }

        if(sessionStorage.getItem(ph_it.firstElementChild.getAttribute('href'))=='1'){
               ph_it.firstElementChild.nextElementSibling.nextElementSibling.children[0].children[0].nextElementSibling.innerText = ph_it.firstElementChild.nextElementSibling.nextElementSibling.children[0].children[0].nextElementSibling.innerText * 1 + 1;
               ph_it.firstElementChild.nextElementSibling.nextElementSibling.children[0].children[0].children[0].classList.add('active');
            }
        }

        analiz(ph_it)

      console.log(sessionStorage);


</script>
