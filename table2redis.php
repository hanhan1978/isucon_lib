<?php

$redis = new Redis();
$redis->connect($_ENV['ISUCONP_REDIS_HOST'] ?? '127.0.0.1', 6379);

function get_db(){
  $host = $_ENV['ISUCONP_DB_HOST'] ?? '127.0.0.1';
  $dbname = 'isuconp';
  $user = 'root';
  $pass = '';
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pass, array(PDO::ATTR_EMULATE_PREPARES => false));
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
  return $pdo;
}

$table  = $argv[1];
$key    = $argv[2];
$limit  = $argv[3];
$offset = $argv[4];

if(is_null($table) || is_null($key) || is_null($limit) || is_null($offset)){
    echo 'usage php '.basename(__FILE__).' [table] [key] [limit] [offset]'.PHP_EOL;
    exit;
}

$pdo = get_db();
$stmt = $pdo->query("SELECT * FROM $table LIMIT $limit OFFSET $offset");
while($u = $stmt -> fetch(PDO::FETCH_ASSOC)) {
    $redis->set($table.'_'.$u[$key], json_encode($u));
}