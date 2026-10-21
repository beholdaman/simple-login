
<?php
    /*ini_set("display_errors", 1);
    ini_set("error_reporting", E_ALL);
    print_r($_POST);*/
?>

<?php

$email_err = false;
if( isset($_POST) && isset($_POST["reset-email"])) {
    $email_err = !filter_var($_POST["reset-email"], FILTER_VALIDATE_EMAIL);
}

$password_err = false;
if( isset($_POST) && isset($_POST["reset-password"])) {
    $password_err = strlen($_POST["reset-password"]) < 8;
}

$password2_err = false;
if( isset($_POST) && isset($_POST["confirmation-password"]) && ($_POST["reset-password"])) {
    $password2_err = ($_POST["confirmation-password"])!=$_POST["reset-password"];
}

include_once("functions.php");

$success_formatting = (isset($_POST) && (isset($_POST["reset-email"]))  && (isset($_POST["reset-password"])) && (isset($_POST["confirmation-password"])) 
            &&
            (!$email_err) && (!$password_err) && (!$password2_err));


$err_message = NULL;
$success_db = false;
if((isset($_POST)) && (isset($_POST["reset-email"])) && (isset($_POST["reset-password"])) && (isset($_POST["confirmation-password"])) ) {

    $select = "SELECT *
                FROM login.appuser
                WHERE email = ? ;
                ";

    $email = $_POST["reset-email"];
    $password = md5($_POST["reset-password"]);
    
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
      <label for="reset-email" class="form-label">Email</label>
      <input name = "reset-email" type="email" class="form-control" id="reset-email" required aria-describedby="email-validation" 
        value="<?php
        if( (isset($_POST)) && (!empty($_POST["reset-email"]))) {
            print($_POST["reset-email"]);
        }
        ?>">
      <?php if($email_err) { ?>
      <div id="email-validation" class="form-text">Email is not formatted properly</div>
      <?php }?>
    </div>

    <!--password-->
    <div class="sm:container" style="padding:10px">
      <label for="reset-password" class="form-label">Password</label>
      <input name="reset-password" type="password" class="form-control" id="reset-password" required aria-describedby="password-validation">
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

     <div class="sm:container" style="padding-left:10px; padding-right:10px; padding-bottom:10px">
        <a class="theme-success underline-success underline-20 hover:underline-100" href="login.php">Login page</a>
    </div>

</form>

</div>
</body>
</html>