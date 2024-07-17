<?php require_once $base_path . '/__header.php'; ?>

<div class="photo_albom">

<?php global $ctt;

$connection = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);

// $res = $connection->query('SELECT category, description FROM category;');$res2 = $connection->query("SELECT img_num, img_desc, link, like, dislike FROM img WHERE id = '$ident';");

$res = $connection->query("SELECT id FROM category WHERE category = '$ctt';"); 

foreach ($res as $result){

$ident = $result['id'];

}

$res = $connection->query("SELECT * FROM img WHERE id = '$ident';");

foreach ($res as $result){

    $img_number = $result["img_num"];

    ?> 

    <div class="photo_item" id="<?php echo $img_number ?>">
    <a href="<?php echo $result['link'] ?>"><img src="<?php echo $result['link'] ?>" ></a>
    <span class="description_image"><?php echo $result['img_desc'] ?></span>
    <div class="like_dislike">
    <div class="like"><a href=""><img class="like_img" src="img/like.svg"></a>
    <span class="span_like"><?php echo $result['like'] ?></span>
    </div>
    <div class="dislike"><a href=""><img class="dis_like_img" src="img/like.svg"></a>
    <span class="span_dislike"><?php echo $result['dislike'] ?></span>
    </div>
    </div>

    <div>
        Количество комментариев:
        <?php
        $result_count = $connection->query("SELECT COUNT(*) AS comment_count FROM comment WHERE img_num = '$img_number';");
        foreach ($result_count as $r_s){
            echo $r_s['comment_count'];
        }
        ?>
    </div>
    <div>
        <a href="/?route=add_comment&category=<?php echo $ctt ?>&img_id=<?php echo $img_number ?>">Добавить комментарий</a>
    </div>

    </div>

    <?php } ?>

    <!-- Для добавления фото -->

    <div class="photo_item">
    <a href="/?route=img_add&category=<?php echo $ctt ?>"><img style="object-fit:contain;" src="img/plus.svg"></a>
    <span class="description_image">Добавить фото</span>
    <div class="like_dislike">
    <div class="like"><a href=""><img class="like_img" src="img/like.svg"></a>
    0
    </div>
    <div class="dislike"><a href=""><img class="dis_like_img" src="img/like.svg"></a>
    0
    </div>
    </div>

    <div>
        Количество комментариев: 0
    </div>

    <div>
        Добавить комментарий
    </div>

</div>

    <!-- Для добавления фото -->

    </div>

    <a class="back_btn" href='/'>На главную</a>

    <div class="modal">
        <img src="" alt="">
    </div>
<?php $connection = NULL ?>
<?php require_once $base_path . '/__footer.php'; ?>

<!--Скрипт для модального окна-->

<script>
    let modal_wind = document.querySelector('.modal');
    let img_for_click = document.querySelectorAll('.photo_item > a');
    let body = document.getElementsByTagName('body')[0];
    let link='';


        for(i=0; i<(img_for_click.length-1); i++){

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

</script> 

<!--Скрипт для модального окна-->

<!--Скрипт для лайков -->

<script>

      let like_dislike = document.querySelectorAll('div.like_dislike');
      let span_like =  document.querySelectorAll('.span_like');
      let span_dislike =  document.querySelectorAll('.span_dislike');
      let local_link = '';
      let request;

      function change(){
      for(i = 0; i < (like_dislike.length - 1); i++){ //Цикл подсвечивает элементы, если они есть в хранилище

        if(sessionStorage.getItem(like_dislike[i].parentElement.firstElementChild.getAttribute('href')) == '1'){
            like_dislike[i].firstElementChild.firstElementChild.firstElementChild.classList.add('active');
            like_dislike[i].firstElementChild.firstElementChild.nextElementSibling.innerText = like_dislike[i].firstElementChild.firstElementChild.nextElementSibling.innerText * 1 + 1;

        }


        else if(sessionStorage.getItem(like_dislike[i].parentElement.firstElementChild.getAttribute('href')) == '-1'){
            like_dislike[i].lastElementChild.firstElementChild.firstElementChild.classList.add('active');
            like_dislike[i].lastElementChild.firstElementChild.nextElementSibling.innerText = like_dislike[i].lastElementChild.firstElementChild.nextElementSibling.innerText * 1 + 1;
        }

        else {sessionStorage.setItem(like_dislike[i].parentElement.firstElementChild.getAttribute('href'),'0')};
    
       }

    //   console.log(sessionStorage);
    }

    window.onload = change();

      for(i=0; i < (like_dislike.length - 1); i++){

        like_dislike[i].addEventListener('click', analiz);

        }

        function analiz(evt){

            evt.preventDefault();

            let father = '';//ссылка на родителя
            let father_element = '';//Родитель элемента

            if(evt.target.classList.contains('like_img')){

                father_element = evt.target.parentElement.parentElement.parentElement.parentElement;

                father = evt.target.parentElement.parentElement.parentElement.parentElement.firstElementChild.getAttribute('href');

                proverka("like", father, evt.target, father_element);
            }

            if(evt.target.classList.contains('dis_like_img')){

                father_element = evt.target.parentElement.parentElement.parentElement.parentElement;

                father = evt.target.parentElement.parentElement.parentElement.parentElement.firstElementChild.getAttribute('href');

                proverka("dislike", father, evt.target, father_element);
            }
        }
   
        function proverka(liker, link, trg, fthr){

            if(sessionStorage.getItem(link)=='0' && liker =='like'){

                trg.classList.add('active');
                trg.parentElement.nextElementSibling.innerText = trg.parentElement.nextElementSibling.innerText * 1 + 1;

                send_likes(fthr.id,trg.parentElement.nextElementSibling.innerText,trg.parentElement.parentElement.nextElementSibling.firstElementChild.nextElementSibling.innerText)

                sessionStorage.removeItem(link);
                sessionStorage.setItem(link,'1');
            }

            else if(sessionStorage.getItem(link)=='0' && liker =='dislike'){

            trg.classList.add('active');
            trg.parentElement.nextElementSibling.innerText = trg.parentElement.nextElementSibling.innerText * 1 + 1;

            send_likes(fthr.id,trg.parentElement.parentElement.previousElementSibling.firstElementChild.nextElementSibling.innerText,trg.parentElement.nextElementSibling.innerText)

            sessionStorage.removeItem(link);
            sessionStorage.setItem(link,'-1');
            }

            else if(sessionStorage.getItem(link)=='1' && liker =='like'){

            trg.classList.remove('active');

            trg.parentElement.nextElementSibling.innerText = trg.parentElement.nextElementSibling.innerText * 1 - 1;

            send_likes(fthr.id, trg.parentElement.nextElementSibling.innerText, trg.parentElement.parentElement.nextElementSibling.firstElementChild.nextElementSibling.innerText);

            sessionStorage.removeItem(link);
            sessionStorage.setItem(link,'0');
            }

            else if(sessionStorage.getItem(link)=='1' && liker =='dislike'){

            fthr.children[2].firstElementChild.firstElementChild.firstElementChild.classList.remove('active');
            trg.parentElement.nextElementSibling.innerText = trg.parentElement.nextElementSibling.innerText*1+1;
            trg.parentElement.parentElement.previousElementSibling.firstElementChild.parentElement.firstElementChild.nextElementSibling.innerText -= 1;

            trg.classList.add('active');

            send_likes(fthr.id, trg.parentElement.parentElement.previousElementSibling.firstElementChild.parentElement.firstElementChild.nextElementSibling.innerText, trg.parentElement.nextElementSibling.innerText);

            sessionStorage.removeItem(link);
            sessionStorage.setItem(link,'-1');
            }

            else if(sessionStorage.getItem(link)=='-1' && liker =='like'){

            fthr.children[2].lastElementChild.firstElementChild.firstElementChild.classList.remove('active');
            trg.parentElement.nextElementSibling.innerText = trg.parentElement.nextElementSibling.innerText * 1 + 1;
            trg.parentElement.parentElement.nextElementSibling.firstElementChild.nextElementSibling.innerText = trg.parentElement.parentElement.nextElementSibling.firstElementChild.nextElementSibling.innerText -1;

            trg.classList.add('active');

            send_likes(fthr.id, trg.parentElement.nextElementSibling.innerText, trg.parentElement.parentElement.nextElementSibling.firstElementChild.nextElementSibling.innerText);

            sessionStorage.removeItem(link);
            sessionStorage.setItem(link,'1');
            }

            else if(sessionStorage.getItem(link)=='-1' && liker =='dislike'){
            trg.parentElement.nextElementSibling.innerText -= 1;

            trg.classList.remove('active');
  
            send_likes(fthr.id, trg.parentElement.parentElement.parentElement.firstElementChild.lastElementChild.innerText, trg.parentElement.nextElementSibling.innerText);

            sessionStorage.removeItem(link);
            sessionStorage.setItem(link,'0');
            }       
        }


        function send_likes(id_i, like_i, dislike_i){

    let xhr = new XMLHttpRequest();

    const url = '/ajax/liker.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader("Content-Type","application/json");

    let data = JSON.stringify({"id" : id_i, "like" : like_i, "dislike" : dislike_i});

    xhr.send(data);

    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            // console.log("ответ:");
            // console.log(JSON.parse(this.responseText));
        }
    };

}


 </script> 
<!--Скрипт для лайков -->