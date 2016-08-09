<?php

$image_dir = __DIR__.'/image';

if(!is_dir($image_dir)){
    mkdir($image_dir);
}


function get_db(){
  $host = '127.0.0.1';
  $dbname = 'isuconp';
  $user = 'root';
  $pass = '';
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pass, array(PDO::ATTR_EMULATE_PREPARES => false));
  return $pdo;
}

$limit = $argv[1];
$offset = $argv[2];
echo("limit $limit, offset $offset\n");
create_image($limit, $offset, $image_dir);

function create_image($limit, $offset, $image_dir){
  $pdo = get_db();
  $stmt = $pdo->query("SELECT * FROM posts WHERE id <= 10000 LIMIT $limit OFFSET $offset ");
  while($post = $stmt -> fetch(PDO::FETCH_ASSOC)) {
      $filename = $image_dir.'/'.$post['id'].".".get_ext($post['mime']);
      file_put_contents($filename, $post['imgdata']);
  }
}

function get_ext($mime){
    if($mime == 'image/jpeg') return 'jpg';
    if($mime == 'image/png') return 'png';
    if($mime == 'image/gif') return 'gif';
}
