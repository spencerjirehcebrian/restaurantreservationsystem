<?php
define('DB_SERVER','localhost');
define('DB_USERNAME','admin');
define('DB_PASSWORD','admin1234');
define('DB_NAME','rrs');

$mysql=new MySQLi(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

if ($mysql===false){
  die("ERROR:".$mysql->connect_error);
}
?>
