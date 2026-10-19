
<?php
    ini_set("display_errors", 1);
    ini_set("error_reporting", E_ALL);
    print_r($_POST);
?>

<?php

$email_err = false;
if( isset($_POST) && isset($_POST["registration-email"])) {
    if(filter_var($_POST["registration-email"], FILTER_VALIDATE_EMAIL) ) {
        $email_err = false;
    }else{
        $email_err = true;
    }
}

$password_err = false;
if( isset($_POST) && isset($_POST["registration-password"])) {
    if(strlen($_POST["registration-password"]) >=8 ) {
        $password_err = false;
    }else{
        $password_err = true;
    }
}

$password2_err = false;
if( isset($_POST) && isset($_POST["confirmation-password"]) && ($_POST["registration-password"])) {
    if(($_POST["confirmation-password"])==$_POST["registration-password"] ) {
        $password2_err = false;
    }else{
        $password2_err = true;
    }
}

include_once("functions.php");

$success_formatting = (isset($_POST) && (isset($_POST["registration-email"]))  && (isset($_POST["registration-password"])) && (isset($_POST["confirmation-password"])) 
            &&
            (!$email_err) && (!$password_err) && (!$password2_err));


$err_message = NULL;
$success_db = false;
if((isset($_POST)) && ($_POST["registration-email"]) && ($_POST["registration-password"]) && ($_POST["confirmation-password"]) ) {

    $select = "SELECT *
                FROM login.appuser
                WHERE email = ? ;
                ";

    $email = $_POST["registration-email"];
    $password = md5($_POST["registration-password"]);
    
    $update = " UPDATE login.appuser SET password = ? 
                WHERE email = ?;
                ";

    $db = open_mysql_connection();

    $stmt1 = mysqli_prepare($db, $select);
    mysqli_stmt_bind_param($stmt1, "s", $email);
    mysqli_stmt_execute($stmt1);
    $result = mysqli_stmt_get_result($stmt1);

    if(mysqli_num_rows($result)==0) {
        $err_message = "email is not registered";
    }else{
        $stmt2 = mysqli_prepare($db, $update);
        mysqli_stmt_bind_param($stmt2, "ss", $password, $email);
        $success_db = mysqli_stmt_execute($stmt2);
       
    }

    mysqli_close($db);
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>Password reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body>
<div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">

<form action= <?php print($_SERVER["PHP_SELF"]);?> method="POST" novalidate="true">

    <?php if($success_formatting && $success_db) { ?>
        <div class="sm:container" style="padding:10px">
        <p class="bg-success fg-contrast-success">Password reset was successful</p>
        </div>
    <?php }?>

    <?php if(!empty($err_message)) { ?>
        <div class="sm:container" style="padding:10px">
        <p class="bg-danger fg-contrast-danger"><?php print($err_message); ?></p>
        </div>
    <?php } ?>

    <!--email-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-email" class="form-label">Email</label>
      <input name = "registration-email" type="email" class="form-control" id="registration-email" required aria-describedby="email-validation">
      <?php if($email_err) { ?>
      <div id="email-validation" class="form-text">Email is not formatted properly</div>
      <?php }?>
    </div>

    <!--password-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-password" class="form-label">Password</label>
      <input name="registration-password" type="password" class="form-control" id="registration-password" required aria-describedby="password-validation">
      <?php if($password_err) { ?>
      <div id="password-validation" class="form-text">Password must be at least 8 characters long</div>
      <?php }?>
    </div>

    <!--password confirmation-->
    <div class="sm:container" style="padding:10px">
      <label for="confirmation-password" class="form-label">Confirm Password</label>
      <input name="confirmation-password" type="password" class="form-control" id="confirmation-password" required aria-describedby="password-confirmation-validation">
      <?php if($password2_err) { ?>
      <div id="password-confirmation-validation" class="form-text">Passwords must coincide</div>
      <?php } ?>
    </div>

    <div class="sm:container" style="padding:10px">
        <button type="submit" class="btn-outline theme-danger">Reset Password</button>
    </div>

</form>

</div>
</body>
</html>