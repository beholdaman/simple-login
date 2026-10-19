
<?php
    ini_set("display_errors", 1);
    ini_set("error_reporting", E_ALL);
    print_r($_POST);    
?>

<?php
$name_err = false;
if( isset($_POST) && isset($_POST["registration-name"])) {
    if( (!empty( $_POST["registration-name"])) ) {
        $name_err = false;
    }else{
        $name_err = true;
    }
}

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

$success_formatting = (isset($_POST) && (!empty($_POST["registration-email"])) && (!empty($_POST["registration-name"])) && (!empty($_POST["registration-password"])) && (!empty($_POST["confirmation-password"])) 
            &&
            (!$name_err) && (!$email_err) && (!$password_err) && (!$password2_err));


?>

<?php 

include_once("functions.php");

$err_message = NULL;
$success_db = false;
if($success_formatting) {
    $insert = "INSERT INTO login.appuser(email, name, password)
            VALUES(?, ?, ?) ;
            ";
   
    $email = $_POST["registration-email"];
    $name = $_POST["registration-name"];
    $password = md5($_POST["registration-password"]);

    $select = "SELECT *
            FROM login.appuser
            WHERE email = ?
            ";


    $db = open_mysql_connection();

    $stmt1 = mysqli_prepare($db, $select);
    mysqli_stmt_bind_param($stmt1, "s", $email);
    mysqli_stmt_execute($stmt1);
    $result = mysqli_stmt_get_result($stmt1);
    print(mysqli_num_rows($result));
    if(mysqli_num_rows($result)>0) {
        $err_message = "email is already registered";
    }else{
        $stmt = mysqli_prepare($db, $insert);
        mysqli_stmt_bind_param($stmt, "sss", $email, $name, $password);
        $success_db = mysqli_stmt_execute($stmt);
       
    }

     mysqli_close($db);

}


?>

<!DOCTYPE html>
<html>
<head>
    <title>registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body>

<div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">

<?php if($success_formatting && $success_db) { ?>
<div class="sm:container" style="padding:10px">
<p class="bg-success fg-contrast-success">Registration of user was successful</p>
</div>
<?php }?>

<?php if(!empty($err_message)) { ?>
<div class="sm:container" style="padding:10px">
<p class="bg-danger fg-contrast-danger"><?php print($err_message); ?></p>
</div>
<?php } ?>

<form method="POST"  novalidate="true" action=<?php print($_SERVER["PHP_SELF"]); ?>>

    <!--name-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-name" class="form-label">Name</label>
      <input name="registration-name" type="text" class="form-control" id="registration-name" 
      value="<?php
      if((isset($_POST)) && (!empty($_POST["registration-name"]))) {
        print($_POST["registration-name"]);
      }
      ?>">
      <?php if($name_err) {?>
      <div name="name-validation-danger" id="name-validation" class="form-text">Name is required</div>
      <?php }?>
    </div>

    <!--email-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-email" class="form-label">Email</label>
      <input name = "registration-email" type="email" class="form-control" id="registration-email" required aria-describedby="email-validation"
      value="<?php
      if((isset($_POST)) && (!empty($_POST["registration-email"])) ) {
        print($_POST["registration-email"]);
      }
      ?>">
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
        <button type="submit" class="btn-solid theme-success">Register</button>
    </div>
</form>
</div>

</body>
</html>