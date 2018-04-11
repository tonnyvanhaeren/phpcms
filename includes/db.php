<?php 

$db['db_host'] = getenv('MYSQL_HOST');
$db['db_user'] = getenv('MYSQL_USER');
$db['db_password'] = getenv('MYSQL_ROOT_PASSWORD');
$db['db_name'] = "cms";

foreach($db as $key => $value){

  define(strtoupper($key), $value );

}


$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

/* if($connection) {

  echo "whe are connected";

} */


?>