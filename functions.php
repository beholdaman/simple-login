
<?php 

function open_mysql_connection() {
    include_once("conf/conf.php");
    $connection = mysqli_connect(myhost, myusername, mypassword, dbname);
    return $connection;
}

function check_login($db, $email, $password) {

    $logged = NULL;

    $select = "SELECT *
                FROM login.appuser
                WHERE email = ? AND password = ? 
                ";
   

    $statement = mysqli_prepare($db, $select);

    mysqli_stmt_bind_param($statement, "ss", $email, $password);

    mysqli_stmt_execute($statement);
   
    $result = mysqli_stmt_get_result($statement);
    
    if(mysqli_num_rows($result)==1) {
        $logged = mysqli_fetch_all($result, MYSQLI_BOTH)[0];
    }
    
    return $logged;
}

?>