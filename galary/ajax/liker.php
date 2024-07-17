<?php

header("Content-Type: application/json");
// разбираем JSON-строку на составляющие встроенной командой

$data = json_decode(file_get_contents("php://input"));
// отправляем в ответ строку с подтверждением

class SaniaClass{
    public function __construct($letter1, $letter2) {
        $this->a_income = $letter1;
        $this->b_income = $letter2;
    }
};

$answer1 = new SaniaClass(1, 1);
$answer2 = new SaniaClass(2, 2);

// $res = $connection->query('SELECT category, description FROM category;');$res2 = $connection->query("SELECT img_num, img_desc, link, like, dislike FROM img WHERE id = '$ident';");

$connection = new PDO('mysql:host=localhost;dbname=galary_bd;charset=utf8',\Settings\USER_NAME,\Settings\PASSWORD);

$res = $connection->exec("UPDATE `img` SET `like` = '$data->like', `dislike` = '$data->dislike' WHERE `img`.`img_num` = $data->id;");

// UPDATE `img` SET `like` = '23', `dislike` = '6' WHERE `img`.`img_num` = 7; чистый запрос на мускл

if(isset($res)){
    $answer = $answer1;
}
else{
    $answer = $answer2;
}

$myJSON = json_encode($answer);

echo $myJSON;

$connection = NULL;
