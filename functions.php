
<?php 

function open_mysql_connection() {
    include_once("conf/conf.php");
    $connection = mysqli_connect(myhost, myusername, mypassword, dbname);
    return $connection;
}

?>