<?php
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);
print_r($_POST);  

include_once("functions.php");
?>

<?php
/*if( (isset($_POST)) && (!empty($_POST["input-email"])) && (!empty($_POST["input-password"])) ) {
    if(($_POST["input-email"]=="chiara.passoni6@studenti.unimi.it") && ($_POST["input-password"]=="FRNHFKBG") ) {
        $logged = true;
    }
}else{
    $logged = false;
}*/

$email_err = false;
if( isset($_POST) && isset($_POST["input-email"])) {
    if(filter_var($_POST["input-email"], FILTER_VALIDATE_EMAIL) ) {
        $email_err = false;
    }else{
        $email_err = true;
    }
}


$logged = NULL;
$error_msg = NULL;
if( (isset($_POST)) && (!empty($_POST["input-email"])) && (!empty($_POST["input-password"])) && (!$email_err)) {

    $db = open_mysql_connection();

    print("22");

    $select = "SELECT *
                FROM login.appuser
                WHERE email = ? AND password = ? 
                ";
    $email = $_POST["input-email"];
    $password = md5($_POST["input-password"]);

    $statement = mysqli_prepare($db, $select);

    mysqli_stmt_bind_param($statement, "ss", $email, $password);

    mysqli_stmt_execute($statement);
   
    $result = mysqli_stmt_get_result($statement);
    
    if(mysqli_num_rows($result)==1) {
        $logged = mysqli_fetch_all($result, MYSQLI_BOTH)[0];
    }else{
        $error_msg = "Failed to login";
    }

    mysqli_close($db);

   
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body>

<?php if(empty($logged)) { ?>
    <div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">
    <form action= <?php print($_SERVER["PHP_SELF"]);?> method="POST">

    <?php if(!empty($error_msg)) { ?>
        <div class="sm:container" style="padding:10px">
        <p class="bg-danger fg-contrast-danger"><?php print($error_msg); ?></p>
        </div>
    <?php } ?>


        <div class="sm:container" style="padding:10px">
            <label for="input-email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="input-email" name="input-email" aria-describedby="emailHelp" placeholder="name@example.com" 
                value= <?php
                if( (isset($_POST)) &&  (!(empty($_POST["input-email"]))) ) {
                    print($_POST["input-email"]);
                }
                ?>>
            <?php if($email_err) { ?>
               <div id="email-validation" class="form-text">Email is not formatted properly</div>
            <?php }?>
        </div>
        <div class="sm:container" style="padding:10px">
            <label for="input-password" class="form-label">Password</label>
            <input type="password" class="form-control" id="input-password" name="input-password">
        </div>

        <div class="sm:container" style="padding-left:10px; padding-right:10px; padding-bottom:10px">
        <a class= "theme-info underline-offset-2 underline-20 hover:underline-100" href="reset.php" >Reset your password</a>
        </div>

        <div class="sm:container" style="padding:10px">
        <button type="submit" class="btn-solid theme-success">Log In</button>
        <a href="registration.php"><button type="button" formaction= "registration.php" class="btn-outline theme-success">Registration</button></a>
        </div>

    </form>
    </div>
<?php }else{ ?>
    <div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">
        <p>Welcome, <?php print($logged["name"]); ?></p>
    </div>
<?php } ?>
</body>
</html>